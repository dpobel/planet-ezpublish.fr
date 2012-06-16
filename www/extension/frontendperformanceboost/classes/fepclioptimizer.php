<?php
/**
 * @copyright Copyright (C) 2012 Damien Pobel. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @package frontendperformanceboost
 */

class fepCliOptimizer extends fepOptimizer
{
    /**
     * The setting containing the environement variables to set
     */
    const ENV_SETTING = 'Environment';

    /**
     * The setting containing the command to execute
     */
    const COMMAND_SETTING = 'Command';


    /**
     * The eZINI object corresponding to ezjscore.ini
     *
     * @var eZINI
     */
    protected $ini;

    /**
     * The section in the ini file containing the setting
     *
     * @var string
     */
    protected $section;

    /**
     * The original code size
     * @see fepCliOptimizer::report()
     *
     * @var int
     */
    protected $originalCodeSize = 0;

    /**
     * The optimized code size
     * @see fepCliOptimizer::report()
     *
     * @var int
     */
    protected $optimizedCodeSize = 0;


    /**
     * The constructor
     *
     * @param eZINI $ini
     * @param string $section
     */
    public function __construct( eZINI $ini, $section )
    {
        $this->ini = $ini;
        $this->section = $section;
    }

    /**
     * Returns the name of the debug settings for this optimizer
     * @see fepCliOptimizer::report() and debug.ini.append.php
     *
     * @return string
     */
    protected function getDebugSettings()
    {
        return strtolower( get_class( $this ) );
    }

    /**
     * Returns the command to execute
     *
     * @return string
     */
    protected function getCommand()
    {
        return $this->ini->variable( $this->section, self::COMMAND_SETTING );
    }

    /**
     * Returns the environment variables to set while executing the command. If
     * not variables is set, returns null
     * @see http://fr.php.net/proc_open
     *
     * @return array|null
     */
    protected function getEnvironmentVariables()
    {
        if ( !$this->ini->hasVariable( $this->section, self::ENV_SETTING ) )
        {
            return null;
        }
        $env = $this->ini->variable( $this->section, self::ENV_SETTING );
        if ( empty( $env ) )
        {
            return null;
        }
        return $env;
    }

    /**
     * Executes the command, writes the content of $code on the standard
     * input of the process and returns the standard output.
     *
     * @param string $code
     * @param int $level
     * @return string
     * @throw Exception if the command does not return 0 or if the process can
     * not be launched.
     */
    public function execute( $code, $level = 2 )
    {
        $this->originalCodeSize = strlen( $code );
        $pipes = array();
        $process = proc_open(
            $this->getCommand(),
            array(
                0 => array( 'pipe', 'r' ),
                1 => array( 'pipe', 'w' ),
                2 => array( 'pipe', 'w' )
            ),
            $pipes,
            null,
            $this->getEnvironmentVariables()
        );
        if ( !is_resource( $process ) )
        {
            throw new Exception( 'proc_open() failed' );
        }
        fwrite( $pipes[0], $code );
        fclose( $pipes[0] );

        stream_set_blocking( $pipes[1], 0 );
        stream_set_blocking( $pipes[2], 0 );

        $errorOutput = '';
        $code = '';
        while ( true )
        {
            $w = $e = array();
            $r = array( $pipes[1], $pipes[2] );
            if ( $r[0] === null )
            {
                unset( $r[0] );
            }
            if ( $r[1] === null )
            {
                unset( $r[1] );
            }
            if ( empty( $r ) )
            {
                break;
            }
            $res = stream_select( $r, $w, $e, 0, 200000 );
            if ( $res === false )
            {
                throw new Exception( 'An error occured while reading the outputs of the command' );
            }
            if ( $res !== 0 )
            {
                foreach ( $r as $fp )
                {
                    if ( $fp === $pipes[2] )
                    {
                        $errorOutput .= stream_get_contents( $fp );
                        if ( feof( $fp ) )
                        {
                            fclose( $pipes[2] );
                            $pipes[2] = null;
                        }
                    }
                    else if ( $fp === $pipes[1] )
                    {
                        $code .= stream_get_contents( $fp );
                        if ( feof( $fp ) )
                        {
                            fclose( $pipes[1] );
                            $pipes[1] = null;
                        }
                    }
                }
            }
        }

        if ( $errorOutput != '' )
        {
            eZDebug::writeWarning( $errorOutput, 'Error output' );
        }

        $return = proc_close( $process );
        if ( $return != 0 )
        {
            throw new Exception( 'Returned value is not 0: ' . $return );
        }
        $this->optimizedCodeSize = strlen( $code );
        self::report(
            $this->getDebugSettings(),
            get_class( $this ),
            $this->originalCodeSize,
            $this->optimizedCodeSize
        );

        return $code;
    }


}


