<?php
namespace Guestbook\Service;

use Zend\View\Helper\AbstractHtmlElement;

/**
 * Class HtmlTableRowHelper
 * @package Guestbook\Service
 */
class HtmlTableRowHelper extends AbstractHtmlElement
{
    /**
     * @param array $items
     * @return string
     */
    public function __invoke(array $items)
    {
        $output = '';
        foreach ($items as $value) {
            $output .= '<td>' . htmlspecialchars($value) . '</td>';
        }
        return '<tr>' . $output . '</tr>' . PHP_EOL;
    }
}
