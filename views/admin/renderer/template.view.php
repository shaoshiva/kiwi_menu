<?php
/**
 * Kiwi apps
 *
 * @copyright  2014 Pascal VINEY
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://lekiwi.fr
 */
?>
<ol id="<?= $id ?>" class="renderer-kiwi-menu">
    <li><div>Some content</div></li>
    <li>
        <div>Some content</div>
        <ol>
            <li><div>Some sub-item content</div></li>
            <li><div>Some sub-item content</div></li>
        </ol>
    </li>
    <li><div>Some content</div></li>
</ol>
<script type="text/javascript">
    require(
            ['jquery-nos', 'static/apps/kiwi_menu/js/nestedSortable/jquery.mjs.nestedSortable.js'],
            function ($) {
                $(function() {
					$('#<?= $id ?>').nestedSortable({
                        maxLevels		: 10,
						handle			: 'div',
						items			: 'li',
						toleranceElement: '> div'
					});
					/*
                    $(':input#<?= $id ?>').each(function() {
                        $(this).nosMedia($(this).data('media-options'));
                    });
                    */
                });
            });
</script>
<style type="text/css">
.renderer-kiwi-menu div {
	background: #eeeeee;
	border: 1px solid #e0e0e0;
	padding: 5px 10px;
}

.renderer-kiwi-menu ol {
    margin: 0;
    padding: 0;
    padding-left: 30px;
}

ol.renderer-kiwi-menu,
ol.renderer-kiwi-menu ol {
    margin: 0 0 0 25px;
    padding: 0;
    list-style-type: none;
}

ol.renderer-kiwi-menu {
    margin: 0;
}

.renderer-kiwi-menu li {
    margin: 5px 0 0 0;
    padding: 0;
}

.renderer-kiwi-menu li div  {
    border: 1px solid #d4d4d4;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    border-color: #D4D4D4 #D4D4D4 #BCBCBC;
    padding: 6px;
    margin: 0;
    cursor: move;
    background: #f6f6f6;
    background: -moz-linear-gradient(top,  #ffffff 0%, #f6f6f6 47%, #ededed 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(47%,#f6f6f6), color-stop(100%,#ededed));
    background: -webkit-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);
    background: -o-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);
    background: -ms-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);
    background: linear-gradient(to bottom,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ededed',GradientType=0 );
}

.renderer-kiwi-menu li.mjs-nestedSortable-branch div {
    background: -moz-linear-gradient(top,  #ffffff 0%, #f6f6f6 47%, #f0ece9 100%);
    background: -webkit-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#f0ece9 100%);

}

.renderer-kiwi-menu li.mjs-nestedSortable-leaf div {
    background: -moz-linear-gradient(top,  #ffffff 0%, #f6f6f6 47%, #bcccbc 100%);
    background: -webkit-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#bcccbc 100%);

}

li.mjs-nestedSortable-collapsed.mjs-nestedSortable-hovering div {
    border-color: #999;
    background: #fafafa;
}

.renderer-kiwi-menu .disclose {
    cursor: pointer;
    width: 10px;
    display: none;
}

.renderer-kiwi-menu li.mjs-nestedSortable-collapsed > ol {
    display: none;
}

.renderer-kiwi-menu li.mjs-nestedSortable-branch > div > .disclose {
    display: inline-block;
}

.renderer-kiwi-menu li.mjs-nestedSortable-collapsed > div > .disclose > span:before {
    content: '+ ';
}

.renderer-kiwi-menu li.mjs-nestedSortable-expanded > div > .disclose > span:before {
    content: '- ';
}
</style>
