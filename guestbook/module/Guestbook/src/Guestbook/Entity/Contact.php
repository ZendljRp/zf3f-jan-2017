<?php
// tag::contactFrontMatter[]
namespace Guestbook\Entity;

/**
 * In order to have an entity with form annotations, you start by importing the
 * \Zend\Form\Annotation namespace with a use statement.
 *
 * Next, you will, at the class level, annotate what the form's name should be
 * and which hydrator should be used.
 */
use Zend\Form\Annotation;

/**
 * @Annotation\Name("Contact")
 * @Annotation\Hydrator("\Zend\Hydrator\ObjectProperty")
 */
class Contact
{
    // end::contactFrontMatter[]
    // tag::contactFields[]
    /**
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"Name:"})
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":25}})
     */
    public $name;

    /**
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"Your email address:"})
     * @Annotation\Type("Zend\Form\Element\Email")
     */
    public $email;

    /**
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"Message:"})
     * @Annotation\Type("Zend\Form\Element\Textarea")
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":250}})
     */
    public $message;

    /**
     * @Annotation\Attributes({"value":"Submit"})
     * @Annotation\Type("Zend\Form\Element\Csrf")
     */
    public $token;

    /**
     * @Annotation\Attributes({"value":"Submit"})
     * @Annotation\Type("Zend\Form\Element\Submit")
     */
    public $submit;
    // end::contactFields[]
}
