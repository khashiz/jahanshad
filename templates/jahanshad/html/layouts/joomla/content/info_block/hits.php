<?php

/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   (C) 2013 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

?>
<dd class="uk-flex uk-flex-middle">
    <i class="far fa-chart-line uk-text-muted icon16 uk-margin-small-left"></i>
    <meta itemprop="interactionCount" content="UserPageVisits:<?php echo $displayData['item']->hits; ?>">
    <span class="uk-text-secondary uk-text-tiny font f500 ss02"><?php echo Text::sprintf('COM_CONTENT_ARTICLE_HITS', $displayData['item']->hits); ?></span>
</dd>