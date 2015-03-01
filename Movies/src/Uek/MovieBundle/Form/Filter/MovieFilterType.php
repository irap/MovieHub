<?php
namespace Uek\MovieBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Uek\MovieBundle\Helpers\GenreHelper;

class MovieFilterType extends AbstractType
{
	protected $genreHelper;
	
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$choices = array();
    	$lables = array();
    	$preferredChoices = array();
    	
    	$choices[] = -1;
    	$lables[] = 'All genres';
    	
    	$genres = $this->genreHelper->getGenres();
    	foreach($genres as $genre)
    	{
    		$choices[] = $genre->getId();
    		$lables[] = $genre->getName();
    	}
    	
    	$genre_choice = new ChoiceList($choices, $lables, $preferredChoices);
    	$builder->add('genre_filter', 'choice', array('choice_list' => $genre_choice, 
    			/* 'multiple' => true, */ /* 'expanded' => true */));
    }

    public function __construct(GenreHelper $genreHelper)
    {
    	$this->genreHelper = $genreHelper;
    }
    
    public function getName()
    {
        return 'movie_filter';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }
}
