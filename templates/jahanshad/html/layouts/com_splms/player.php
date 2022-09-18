<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2021 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

$app = Factory::getApplication('com_splms');
$params = $app->getParams();
$assets_path = Uri::root(true) . '/components/com_splms/assets/';

$video = $displayData['video'];
$thumbnail = (isset($displayData['thumbnail']) && $displayData['thumbnail']) ? Uri::root(true) . '/' . $displayData['thumbnail'] : '';

$doc = Factory::getDocument();
?>
<div class="uk-border-rounded uk-overflow-hidden uk-box-shadow-small">
    <div>
        <div class="arvanplayer" config="<?php echo $video; ?>" data-config='{"currenttime": 0, "autostart": false, "repeat": false, "mute": false, "preload": "auto", "controlbarautohide": true, "lang": "en", "aspectratio": "", "color": "#ffcc00", "controls": true, "touchnativecontrols": false, "displaytitle": true, "displaycontextmenu": true, "logoautohide": true}'></div>
    </div>
</div>