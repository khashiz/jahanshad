<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_logreg
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;

$comParams = JComponentHelper::getParams('com_logregsms');
$session = JFactory::getSession();
$app = JFactory::getApplication();

$module_id = $module->id;
?>
ثثثثثثثثثث
<div id="mod_logreg<?php echo $module->id; ?>" class="mod_logreg">
  <?php require "step1.php"; ?>
</div>

<input type="hidden" id="delayMiliSecond<?php echo $module->id; ?>" value="<?php echo $params->get('delayMiliSecond', 2000); ?>">

<div id="modLogRegLoading<?php echo $module->id; ?>"></div>

<style>
  #modLogRegLoading<?php echo $module->id; ?> {
    display: none;
  }

  #modLogRegLoading<?php echo $module->id; ?>.show {
    display: block;
    position: absolute;
    z-index: 99999;
    background-image: url('<?php echo Uri::root(true); ?>/modules/mod_logreg/assets/loading.gif');
    background-color: #333;
    opacity: 0.6;
    background-repeat: no-repeat;
    background-position: center;
    left: 0;
    bottom: 0;
    right: 0;
    top: 0;
  }
</style>