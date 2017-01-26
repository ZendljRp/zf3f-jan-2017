<?php
namespace Market\Form\Filter;
use Zend\Filter\FilterInterface;
class ToFloat implements FilterInterface
{
	public function filter($value)
	{
		return (float) $value;
	}
}
