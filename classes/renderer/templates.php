<?php
/**
 * Kiwi apps
 *
 * @copyright  2014 Pascal VINEY
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://lekiwi.fr
 */

namespace Kiwi\Menu;

class Renderer_Template extends \Nos\Renderer
{
    public function before_construct(&$attributes, &$rules)
    {
        $attributes['class'] = rtrim('kiwi-template '.\Arr::get($attributes, 'class'));
        if (empty($attributes['id'])) {
            $attributes['id'] = uniqid('template_');
        }
    }

    public function build()
    {
        return $this->template(static::renderer(array(
            'input_name' => $this->name,
            'selected' => array(
                // Converts null to 0
                'id' => (string) (int) $this->value,
            ),
            'treeOptions' => array(
                'context' => \Arr::get($this->renderer_options, 'context', null),
            ),
            'height' => \Arr::get($this->renderer_options, 'height', '150px'),
            'width' => \Arr::get($this->renderer_options, 'width', null),
        )));
    }

	/**
	 * Returns a template builder renderer
	 *
	 * @param array $options
	 * @return string
	 */
    public static function renderer($options = array())
    {
        $options = \Arr::merge(array(
            'urlJson' => 'admin/kiwi_template/inspector/templateitem/json',
            'reloadEvent' => 'Kiwi\Template\\Model_Templateitem',
            'input_name' => null,
            'selected' => array(
                'id' => null,
                'model' => 'Kiwi\Template\\Model_Templateitem',
            ),
            'columns' => array(
                array(
                    'dataKey' => 'title',
                ),
            ),
            'treeOptions' => array(
                'context' => null
            ),
            'height' => '150px',
            'width' => null,
            'contextChange' => true,
        ), $options);

        return \View::forge('kiwi_template::admin/renderer/template', array(
			'id' => uniqid('renderer-template-')
		), false);
//		(string) \Request::forge('admin/kiwi_template/inspector/templateitem/list')->execute(
//            array(
//                'inspector/modeltree_radio',
//                array(
//                    'params' => $options,
//                )
//            )
//        )->response();
    }
}
