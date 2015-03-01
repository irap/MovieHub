<?php
namespace Uek\MovieBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Uek\MovieBundle\Helpers\GenreHelper;
use Uek\MovieBundle\Entity\Genre;


class MovieFilterType extends AbstractType
{
	protected $genreHelper;
	
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$choices = array();
    	$lables = array();
    	$default_choice = -1;
    	if ($this->genreHelper->getFilterGenre() != null)
    	{
    		$default_choice = $this->genreHelper->getFilterGenre()->getId();
    	}
    	
    	$choices[] = -1;
    	$lables[] = 'All genres';
    	
    	$genres = $this->genreHelper->getGenres();
    	foreach($genres as $genre)
    	{
    		$choices[] = $genre->getId();
    		$lables[] = $genre->getName();
    	}
    	
    	$genre_choice = new ChoiceList($choices, $lables);
    	$builder->add('filter_by', 'choice', array('choice_list' => $genre_choice, 
    			/* 'multiple' => true, */ /* 'expanded' => true */ 'data' => $default_choice));
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
