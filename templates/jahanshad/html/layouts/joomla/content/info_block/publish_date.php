<?php

/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   (C) 2013 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

?>
<dd class="uk-flex uk-flex-middle">
    <i class="far fa-calendar-o uk-text-muted icon16 uk-margin-small-left"></i>
    <time class="uk-text-secondary uk-text-tiny font f500 ss02" datetime="<?php echo HTMLHelper::_('date', $displayData['item']->publish_up, 'c'); ?>" itemprop="datePublished"><?php echo JHtml::date($displayData['item']->publish_up, 'd M Y'); ?></time>
</dd>