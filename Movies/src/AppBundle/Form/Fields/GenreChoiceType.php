<?php

/**
 * GenreChoiceType contains a custom genre choise form field.
 */
namespace AppBundle\Form\Fields;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

/**
 * Custom genre choice form field.
 * 
 * @author ipurdenko
 */
class GenreChoiceType extends AbstractType
{
	protected $genres;
	protected $selected_genre;
	
	/**
	 * {@inheritdoc}
	 */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$genre_choices = array(0);
    	$genre_names = array('All genres');
    	 
    	foreach($this->genres as $genre)
    	{
    		$genre_choices[] = $genre->getId();
    		$genre_names[] = $genre->getName();
    	}
    	
    	$selected = 0;
    	if ($this->selected_genre)
    	{
    		$selected = $this->selected_genre->getId();
    	}
    	
    	$builder
    	->add('genre_choice', 'choice',
    		array('choice_list' => new ChoiceList($genre_choices, $genre_names),
   			'label' => 'Filter by genre', 'data' => $selected,
    				'attr' => array('id' => 'genre_choice')))
    	->add('filter', 'submit', array(
        	'validation_groups' => false));
    	
    }

    /**
     * Construct object.
     * @param unknown $genres
     * @param unknown $selected_genre
     */
    public function __construct($genres, $selected_genre)
    {
    	$this->genres = $genres;
    	$this->selected_genre = $selected_genre;
    }
    
	/**
	 * {@inheritdoc}
	 */
    public function getName()
    {
        return 'genre_choice';
    }

    /**
	 * {@inheritdoc}
	 */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering')
        		
        ));
    }
}
