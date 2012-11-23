<?php

namespace Planet\PlanetBundle\Import\Parser\Exception;

use Exception;

/**
 * Invalid exception. This exception is thrown when the parser is in an invalid
 * state. For instance, when trying to parse an invalid RSS feed or when trying
 * to import some tweets but the settings are invalid.
 */
class Invalid extends Exception
{

}
