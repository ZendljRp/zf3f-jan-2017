<?php
namespace Application\Helper;
use Zend\View\Helper\AbstractHelper;
class LeftLinks extends AbstractHelper
{
	public function __invoke(array $categories, $urlPrefix)
    {
		$output = '<ul>';
		foreach ($categories as $item) {
			$output .= '<li>' 
					.  '<a href="' . $urlPrefix . '/' . $item . '">'
					.  $item
					.  '</a></li>'; 
		}
		$output .= '</ul>';
		return $output;
	}
}