<?php
namespace Uek\MovieBundle\Form\Sort;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Uek\MovieBundle\Helpers\SortHelper;

class MovieSortType extends AbstractType
{
	protected $sort_helper = 0;
	
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$sort_helper = $this->sort_helper;
    	
    	$choices = $sort_helper->getChoices();
    	$lables = $sort_helper->getLables();
    	$default_choice = $sort_helper->getCurrentChoice();
    	 
    	$sort_choice = new ChoiceList($choices, $lables);
    	$builder->add('sort_by', 'choice', array('choice_list' => $sort_choice, 
    			/* 'multiple' => true, */ /* 'expanded' => true */ 'data' => $default_choice));
    }

    public function __construct(SortHelper $sort_helper)
    {
    	$this->sort_helper = $sort_helper;
    }
    
    public function getName()
    {
        return 'movie_sort';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }
}
