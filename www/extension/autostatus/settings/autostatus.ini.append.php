<?php /*

[TwitterSettings]
ConsumerKey=xwONpUbHRNQaMC35jyNLw
ConsumerSecret=QJCWPOeiCrnkzvvs67YhH82S5TgExtIwxaJtPRDno
SiteURL=https://api.twitter.com/oauth

[IdenticaSettings]
ConsumerKey=a31330654f1a0762c68bdb75298c291a
ConsumerSecret=486250def71a71b3aab304117bca6c54
SiteURL=https://identi.ca/api/oauth

[AutoStatusSettings]
# array of datatypes that can be used to store
# a status message
StatusDatatype[]
StatusDatatype[]=ezstring
StatusDatatype[]=eztext

# array of datatypes that can be used to trigger
# the sending of a status message
# If you add a new type here, make sure the return value
# of the content() method of the corresponding eZContentObjectAttribute
# object can be interpreted as a boolean value. Check l.287 in
# eventtypes/event/autostatus/autostatustype.php
StatusTriggerDatatype[]
StatusTriggerDatatype[]=ezboolean

# available social networks
SocialNetworks[]
SocialNetworks[]=twitter
SocialNetworks[]=identica
# alwayserror is a test social network that always throws
# an exception when trying to update the status
#SocialNetworks[]=alwayserror

# when Debug is set to enabled, no status update is send
# status updates are just logged
Debug=disabled
LogFile=autostatus.log

[AutoStatusLogSettings]
Limit=20

# Maximum age (in days) of events in autostatus/log
# Events older than MaxAge will be removed by the cronjobs
# clean_events.php that should be launched in the infrequent
# cronjob part.
MaxAge=100

[URLShorteningSettings]
Shortener=isgd

[URLShortener_isgd]
Name=is.gd
MaxLengh=20

[URLShortener_googl]
Name=Goo.gl
# the ApiKey is not strictly required by Goo.gl but with it, you can get some
# statistics on the shortened URLs
# to get an API Key go to: https://code.google.com/apis/console
ApiKey=
MaxLengh=20

*/ ?>
