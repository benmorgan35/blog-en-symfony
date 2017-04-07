<?php

namespace BG\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class BilletEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */


   public function getParent()
   {
       return BilletType::class;
   }


}
