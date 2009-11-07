<?php /*
#
# $Id$
# $HeadURL$
#

[CronjobSettings]
ExtensionDirectories[]=planete

[CronjobPart-planete]
Scripts[]=rssimport_planete.php
Scripts[]=cleanup_planetarium.php
Scripts[]=staticcache_cleanup.php

[CronjobPart-static]
Script[]=staticcache_cleanup.php

*/ ?>
