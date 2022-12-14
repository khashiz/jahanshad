<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $app->getDocument()->getWebAssetManager();
$wa->registerAndUseScript('mod_menu', 'mod_menu/menu.min.js', [], ['type' => 'module']);
$wa->registerAndUseScript('mod_menu', 'mod_menu/menu-es5.min.js', [], ['nomodule' => true, 'defer' => true]);

$id = '';

if ($tagId = $params->get('tag_id', '')) {
    $id = ' id="' . $tagId . '"';
}

$user =& JFactory::getUser();
?>
<div class="uk-width-auto uk-flex uk-flex-middle uk-hidden@s">
    <span href="#userMenu" data-uk-toggle class="uk-button uk-button-default uk-button-large uk-border-rounded uk-button-icon uk-box-shadow-small"><i class="fas fa-user"></i></span>
</div>
<div class="uk-width-auto uk-flex uk-flex-middle uk-visible@s">
    <a href="#" class="uk-button uk-button-primary uk-button-large uk-border-rounded uk-box-shadow-small">
        <i class="far fa-user"></i>
        <span><?php echo $user->name; ?></span>
    </a>
    <div data-uk-drop="pos: bottom-left; offset:0; animation: uk-animation-slide-bottom-small; target: header .uk-container .uk-grid; shift: false; flip: false;">
        <div class="topDrop">
            <div class="topDropWrapper">
                <ul<?php echo $id; ?> class="listContainer hasEnd uk-padding-small <?php echo $class_sfx; ?>">
					<?php foreach ($list as $i => &$item) {
						$itemParams = $item->getParams();
						$class      = 'nav-item item-' . $item->id;

						if ($item->id == $default_id) {
							$class .= ' default';
						}

						if ($item->id == $active_id || ($item->type === 'alias' && $itemParams->get('aliasoptions') == $active_id)) {
							$class .= ' current';
						}

						if (in_array($item->id, $path)) {
							$class .= ' active';
						} elseif ($item->type === 'alias') {
							$aliasToId = $itemParams->get('aliasoptions');

							if (count($path) > 0 && $aliasToId == $path[count($path) - 1]) {
								$class .= ' active';
							} elseif (in_array($aliasToId, $path)) {
								$class .= ' alias-parent-active';
							}
						}

						if ($item->type === 'separator') {
							$class .= ' divider';
						}

						if ($item->deeper) {
							$class .= ' deeper';
						}

						if ($item->parent) {
							$class .= ' parent';
						}

						echo '<li class="' . $class . '">';

						switch ($item->type) :
							case 'separator':
							case 'component':
							case 'heading':
							case 'url':
								require ModuleHelper::getLayoutPath('mod_menu', 'user_' . $item->type);
								break;

							default:
								require ModuleHelper::getLayoutPath('mod_menu', 'user_url');
								break;
						endswitch;

						// The next item is deeper.
						if ($item->deeper) {
							echo '<ul class="mod-menu__sub list-unstyled small">';
						} elseif ($item->shallower) {
							// The next item is shallower.
							echo '</li>';
							echo str_repeat('</ul></li>', $item->level_diff);
						} else {
							// The next item is on the same level.
							echo '</li>';
						}
					}
					?>
                </ul>
            </div>
        </div>
    </div>
</div>