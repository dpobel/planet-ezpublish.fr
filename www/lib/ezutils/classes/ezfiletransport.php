<?php
//
// Definition of eZFileTransport class
//
// Created on: <10-Dec-2002 14:41:22 amos>
//
// SOFTWARE NAME: eZ Publish
// SOFTWARE RELEASE: 4.0.1
// BUILD VERSION: 22260
// COPYRIGHT NOTICE: Copyright (C) 1999-2008 eZ Systems AS
// SOFTWARE LICENSE: GNU General Public License v2.0
// NOTICE: >
//   This program is free software; you can redistribute it and/or
//   modify it under the terms of version 2.0  of the GNU General
//   Public License as published by the Free Software Foundation.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of version 2.0 of the GNU General
//   Public License along with this program; if not, write to the Free
//   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
//   MA 02110-1301, USA.
//
//

/*! \file ezsendmailtransport.php
*/

/*!
  \class eZFileTransport ezfiletransport.php
  \brief Sends the email message to a file.

*/

//include_once( 'lib/ezutils/classes/ezmailtransport.php' );
//include_once( 'lib/ezfile/classes/ezfile.php' );

class eZFileTransport extends eZMailTransport
{
    /*!
     Constructor
    */
    function eZFileTransport()
    {
    }

    /*!
     \reimp
    */
    function sendMail( eZMail $mail )
    {
        $ini = eZINI::instance();
        $sendmailOptions = '';
        $emailFrom = $mail->sender();
        $emailSender = $emailFrom['email'];
        if ( !$emailSender || count( $emailSender) <= 0 )
            $emailSender = $ini->variable( 'MailSettings', 'EmailSender' );
        if ( !$emailSender )
            $emailSender = $ini->variable( 'MailSettings', 'AdminEmail' );
        if ( !eZMail::validate( $emailSender ) )
            $emailSender = false;

        $isSafeMode = ini_get( 'safe_mode' );
        if ( $isSafeMode and
             $emailSender and
             $mail->sender() == false )
            $mail->setSenderText( $emailSender );

        $filename = time() . '-' . rand() . '.mail';

        $data = preg_replace('/(\r\n|\r|\n)/', "\r\n", $mail->headerText() . "\n" . $mail->body() );
        return eZFile::create( $filename, 'var/log/mail', $data );
    }
}

?>
