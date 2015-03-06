<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Uek\MovieBundle\Entity\Review;
use Uek\MovieBundle\Entity\Movie;
use Uek\MovieBundle\Entity\Genre;
use Uek\UserBundle\Entity\User;
use Uek\StoreBundle\Entity\Order;
use Uek\StoreBundle\Entity\OrderStatus;

use AppBundle\DemoMovieList;

// /**
//  * @Route("/demo")
//  */
class DemoController extends Controller
{
	private $demo_movie_list = array(
			['These Final Hours',
					['Drama','Thriller'],
					'A self-obsessed young man makes his way to the party-to-end-all-parties on the last day on Earth, but ends up saving the life of a little girl searching for her father. Their relationship ultimately leads him on the path to redemption.',
					'Sarah Snook, Jessica De Gouw, Nathan Phillips',
					'http://static.hd-trailers.net/images/these-final-hours-122456-poster-xlarge-resized.jpg',
					'http://www.imdb.com/video/imdb/vi1426370073/imdb/embed?autoplay=false&width=480',
					'15.2',
			],
	
			['Unfinished Business',
					['Comedy'],
					'A hard-working small business owner and his two associates travel to Europe to close the most important deal of their lives. But what began as a routine business trip goes off the rails in every way imaginable - and unimaginable - way, including unplanned stops at a massive sex fetish event and a global economic summit.',
					'Vince Vaughn, Dave Franco, Tom Wilkinson',
					'http://static.hd-trailers.net/images/unfinished-business-130375-poster-xlarge-resized.jpg',
					'http://www.imdb.com/video/imdb/vi1415687705/imdb/embed?autoplay=false&width=480',
					'11.4',
			],
	
			['Cymbeline',
					['Drama'],
					'Academy Award® nominees Ethan Hawke (Best Supporting Actor, Boyhood, 2014) and Ed Harris (Best Actor, Pollock, 2000) lead a powerhouse cast including Milla Jovovich, John Leguizamo, Penn Badgley, Dakota Johnson and Anton Yelchin, with Bill Pullman and Delroy Lindo in a gritty story of a take-no-prisoners war between dirty cops and an outlaw biker gang. When extortion, betrayal, and fiery passions threaten his criminal empire, a drug kingpin (Harris) is driven to desperate measures in this explosive, modern retelling of Shakespeare’s timeless play.',
					'Ethan Hawke, Ed Harris, Milla Jovovich',
					'http://static.hd-trailers.net/images/cymbeline-poster-20150304-resized.jpg',
					'http://www.hd-trailers.net/embed/anarchy/9-trailer-480p',
					'19.41',
			],
	
			['No Escape',
					['Action', 'Thriller'],
	 'An intense international thriller, NO ESCAPE centers on an American businessman (Wilson) as he and his family settle into their new home in Southeast Asia. Suddenly finding themselves in the middle of a violent political uprising, they must frantically look for a safe escape as rebels mercilessly attack the city. Directed by John Erick Dowdle and written together with his brother Drew, NO ESCAPE stars Owen Wilson, Pierce Brosnan and Lake Bell.',
	 'Owen Wilson, Pierce Brosnan, Lake Bell',
	 'http://static.hd-trailers.net/images/no-escape-57215-poster-xlarge-resized.jpg',
							'http://www.hd-trailers.net/embed/no-escape/1-trailer-480p/',
							'13.11',
					],
	
					['Self/less',
							['Drama','Sci-Fi','Thriller'],
							'In this provocative psychological science fiction thriller, an extremely wealthy man (Academy Award® Winner Ben Kingsley) dying from cancer undergoes a radical medical procedure that transfers his consciousness into the body of a healthy young man (Ryan Reynolds). But all is not as it seems when he starts to uncover the mystery of the body’s origin and the organization that will kill to protect its cause.',
							'Matthew Goode, Ryan Reynolds, Michelle Dockery',
							'http://static.hd-trailers.net/images/self-less-99409-poster-xlarge-resized.jpg',
							'http://www.hd-trailers.net/embed/self-less/1-trailer-480p/',
							'11.31',
					],
	
					['A Year in Champagne',
							['Documentary'],
							'The exploding cork. Endless tiny bubbles floating up and up in the glass. An indulgence. A celebration. A seduction. A triumph. This is the essence of champagne, isn’t it? With renowned wine importer Martine Saunier as our guide, A YEAR IN CHAMPAGNE provides a rare glimpse behind the scenes into the real champagne through six houses, from small independent makers like Champagne Saint-Chamant, where each and every bottle is still turned by hand in the cellars, to the illustrious houses of Gosset and Bollinger, which have been instrumental in shaping the image of champagne around the world.',
							'Martine Saunier',
							'http://static.hd-trailers.net/images/a-year-in-champagne-152824-poster-xlarge-resized.jpg',
							'http://www.hd-trailers.net/embed/a-year-in-champagne/3-trailer-no-1-480p/',
							'9.32',
					],
	
					['Champs',
							['Documentary'],
							'Boxing, "the poor man’s sport," has long given kids from America’s roughest neighborhoods an opportunity to escape violence with violence. But with success in the ring comes new fights for which there is no training: champions are made and broken in the blink of an eye, and young men thrust into the spotlight are often ill-equipped for the fame and fortune that accompany a title belt. Built around the stories of heavyweight legends Mike Tyson, Evander Holyfield and Bernard Hopkins, CHAMPS balances these uncensored recollections with gorgeous reenactments, classic fight footage, and candid interviews with Mark Wahlberg, Denzel Washington, Ron Howard, Spike Lee, Mary J. Blige and 50 Cent. More than just a sports documentary, CHAMPS examines what it means to pursue the American Dream through boxing, painting a picture of a controversial and unregulated sport in a moment of crisis.
',
							'50 Cent, Mary J. Blige, Evander Holyfield',
							'http://static.hd-trailers.net/images/champs-97237-poster-xlarge-resized.jpg',
							'http://www.hd-trailers.net/embed/champs/2-trailer-480p/',
							'10.50',
					],
	
					['Avengers: Age of Ultron',
							['Action','Adventure','Fantasy','Sci-Fi'],
							'When Tony Stark (Robert Downey Jr.) jumpstarts a dormant peacekeeping program, things go terribly awry, forcing him, Thor (Chris Hemsworth), the Incredible Hulk (Mark Ruffalo) and the rest of the Avengers to reassemble. As the fate of Earth hangs in the balance, the team is put to the ultimate test as they battle Ultron (James Spader), a technological terror hell-bent on human extinction. Along the way, they encounter two mysterious and powerful newcomers, Pietro and Wanda Maximoff.',
							'Robert Downey Jr., Chris Evans, Mark Ruffalo',
							'http://static.hd-trailers.net/images/460f1e40-5ad4-11e4-b4f0-a11f6a7a2880_Avg2_Teaser_1-Sht_v3_lg-resized.jpg',
							'http://www.hd-trailers.net/embed/avengers-age-of-ultron/1-trailer-3-480p/',
							'18.50',
					],
	
					['Spectre',
							['Action','Adventure','Thriller'],
							'A cryptic message from Bond’s past sends him on a trail to uncover a sinister organisation. While M battles political forces to keep the secret service alive, Bond peels back the layers of deceit to reveal the terrible truth behind SPECTRE.',
							'Daniel Craig, Christoph Waltz, Ralph Fiennes',
							'http://static.hd-trailers.net/images/spectre-poster-20150212-resized.jpg',
							'http://www.hd-trailers.net/embed/spectre/2-sam-mendes-vlog-480p/',
							'17.10',
					],
	
					['Last Knights',
							['Action','Adventure'],
							'Academy Award® Nominee Clive Owen (Best Performance by an Actor in a Supporting Role, Closer, 2004) delivers an electrifying performance as a fallen warrior who rises against a corrupt and sadistic ruler to avenge his dishonored master, Academy Award® Winner Morgan Freeman (Best Performance by an Actor in a Supporting Role, Million Dollar Baby, 2004), in this epic, sword-clashing adventure of loyalty, honor, and vengeance.',
							'Clive Owen, Morgan Freeman, Aksel Hennie',
							'http://static.hd-trailers.net/images/last-knights-poster-20150304-resized.jpg',
							'http://www.hd-trailers.net/embed/last-knights/1-trailer-480p/',
							'13.25',
					],
	
					['The Divergent Series: Insurgent',
							['Adventure','Sci-Fi','Thriller'],
	 'One choice can transform you-or it can destroy you. But every choice has consequences, and as unrest surges in the factions all around her, Tris Prior must continue trying to save those she loves--and herself--while grappling with haunting questions of grief and forgiveness, identity and loyalty, politics and love. Tris\'s initiation day should have been marked by celebration and victory with her chosen faction; instead, the day ended with unspeakable horrors. War now looms as conflict between the factions and their ideologies grows. And in times of war, sides must be chosen, secrets will emerge, and choices will become even more irrevocable--and even more powerful. Transformed by her own decisions but also by haunting grief and guilt, radical new discoveries, and shifting relationships. Tris must fully embrace her Divergence, even if she does not know what she may lose by doing so.',
									'Shailene Woodley, Ansel Elgort, Theo James',
									'http://static.hd-trailers.net/images/the-divergent-series-insurgent-poster-20140131-resized.jpg',
									'http://www.hd-trailers.net/embed/the-divergent-series-insurgent/2-final-trailer-480p/',
									'12.40',
							],
	
							['Terminator Genisys',
									['Action','Adventure','Sci-Fi','Thriller'],
									'When John Connor (Jason Clarke), leader of the human resistance, sends Sgt. Kyle Reese (Jai Courtney) back to 1984 to protect Sarah Connor (Emilia Clarke) and safeguard the future, an unexpected turn of events creates a fractured timeline. Now, Sgt. Reese finds himself in a new and unfamiliar version of the past, where he is faced with unlikely allies, including the Guardian (Arnold Schwarzenegger), dangerous new enemies, and an unexpected new mission: To reset the future…',
									'J.K. Simmons, Emilia Clarke, Jai Courtney',
									'http://static.hd-trailers.net/images/terminator-genisys-poster-20150201-resized.jpg',
									'http://www.hd-trailers.net/embed/terminator-genisys/1-big-game-spot-480p/',
									'13.90',
							],
	
							['The SpongeBob Movie: Sponge Out of Water',
									['Animation','Adventure','Comedy','Family'],
									'SpongeBob SquarePants, the world’s favorite sea dwelling invertebrate, comes ashore to our world for his most super-heroic adventure yet.',
									'Tom Kenny, Antonio Banderas, Bill Fagerbakke',
									'http://static.hd-trailers.net/images/spongebob-sponge-out-of-water-147890-poster-xlarge-resized.jpg',
									'http://www.hd-trailers.net/embed/the-spongebob-squarepants-movie-sponge-out-of-water/3-trailer-no-1-480p/',
									'17.30',
							],
	
							['Still Alice',
									['Drama'],
									'Dr. Alice Howland (Julianne Moore) is a renowned linguistics professor at Columbia University. When words begin to escape her and she starts becoming lost on her daily jogs, Alice must come face-to-face with a devastating diagnosis: early-onset Alzheimer\'s disease. As the once-vibrant woman struggles to hang on to her sense of self for as long as possible, Alice\'s three grown children must watch helplessly as their mother disappears more and more with each passing day.',
									'Julianne Moore, Alec Baldwin, Kristen Stewart',
									'http://static.hd-trailers.net/images/still-alice-86717-poster-xlarge-resized.jpg',
									'http://www.hd-trailers.net/embed/still-alice/3-trailer-no-1-480p/',
									'19.55',
							],
					);
	
	/**
	 * @Route("/demo/create", name="uek_create_demo")
	 */
	public function createDemoAction()
	{
		// First, reset the previous demo movies
		$this->resetDemoAction();
		
		// Second, add new ones
		$this->createOrderStatusesAction();

		$em = $this->getDoctrine()->getManager();
		foreach ($this->demo_movie_list as list($title, $genre_list, $description, $actors, $coverArt, $videoUri, $price)) 
		{
			$movie = new Movie();
			$movie->setTitle($title);
			$movie->setDescription($description);
			$movie->setActors($actors);
			$movie->setCoverArt($coverArt);
			$movie->setVideoUri($videoUri);
			$movie->setPrice((float)$price);
			$em->persist($movie);
				
			foreach ($genre_list as $gname)
			{
				$genre = $em->getRepository('UekMovieBundle:Genre')->findOneByName($gname);
				if ($genre == null)
				{
					$genre = new Genre();
					$genre->setName($gname);
					$em->persist($genre);
					$em->flush();
				}

				$movie->addGenre($genre);
			}
		}

		$em->flush();
		
		if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) 
		{
			$movies = $em->getRepository('UekMovieBundle:Movie')->findAll();
			foreach ($movies as $movie)
			{
				if (rand(0, 1) == 1)
				{
					$this->addReviewAction($movie->getId());
				}
				if (rand(0, 2) == 1)
				{
					$this->addOrderAction($movie->getId());
				}
				else 
				{
					$this->addPaidOrderAction($movie->getId());
				}
			}
		}
		
		return $this->redirect($this->generateUrl('uek_homepage'));
	}

	/**
	 * @Route("/demo/reset", name="uek_reset_demo")
	 */
	public function resetDemoAction()
	{
		$em = $this->getDoctrine()->getManager();

		$movies = $em->getRepository('UekMovieBundle:Movie')->findAll();
		foreach ($movies as $movie) {
			$em->remove($movie);
		}

		$reviews = $em->getRepository('UekMovieBundle:Review')->findAll();
		foreach ($reviews as $review) {
			$em->remove($review);
		}

		$genres = $em->getRepository('UekMovieBundle:Genre')->findAll();
		foreach ($genres as $genre) {
			$em->remove($genre);
		}

		$orders = $em->getRepository('UekStoreBundle:Order')->findAll();
		foreach ($orders as $order) {
			$em->remove($order);
		}
		
		$em->flush();

		$movies = $em->getRepository('UekMovieBundle:Movie')->findAll();
		return $this->redirect($this->generateUrl('uek_homepage'));
	}

	/**
	 * @Route("/demo/add/review/movie/{id}", name="uek_add_demo_review")
	 */
	public function addReviewAction($id)
	{
	    if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
    		return $this->render('UekUserBundle:Security:please.login.html.twig');
    	}
		$user = $this->get('security.token_storage')->getToken()->getUser();

		$em = $this->getDoctrine()->getManager();
		$movie = $em->getRepository('UekMovieBundle:Movie')->findOneById($id);
     	if ($user != null && $movie != null)
     	{
			$review = new Review ();
			$review->setReviewText ( "This is a review #" . $review->getId () . "for " . $movie->getTitle () . " written by " . $user->getUsername());
			
			$review->setUser ( $user );
			$review->setMovie ( $movie );
			$em->persist ( $review );
    		
     		$em->flush();

     		return $this->redirect($this->generateUrl('uek_movie', array('id' => $movie->getId())));
     	}
    	
    	return $this->redirect($this->generateUrl('uek_homepage'));
	}    	 

	/**
	 * @Route("/demo/add/order/movie/{id}", name="uek_add_demo_order")
	 */
	public function addOrderAction($id)
	{
		if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
			return $this->render('UekUserBundle:Security:please.login.html.twig');
		}
		$user = $this->get('security.token_storage')->getToken()->getUser();
		
		$em = $this->getDoctrine()->getManager();
		$username= $this->get('security.context')->getToken()->getUser();
		$user = $em->getRepository('UekUserBundle:User')->findOneByUsername($username);
		$movie = $em->getRepository('UekMovieBundle:Movie')->findOneById($id);
		if ($user != null && $movie != null && !$movie->isPaidByUser($user) && !$movie->isOrderedByUser($user))
		{
			$in_progress = $em->getRepository('UekStoreBundle:OrderStatus')->findOneById(OrderStatus::IN_PROGRESS);

			$order = new Order ();
			$order->setStatus ( $in_progress );
			$em->persist ( $order );
					
			$order->setUser ( $user );
			$order->addMovie ( $movie );
	
			$em->flush();
	
    		return $this->redirect($this->generateUrl('uek_movie', array('id' => $movie->getId())));
		}
		 
		return $this->redirect($this->generateUrl('uek_homepage'));
	}
	
	/**
	 * @Route("/demo/add/paid/order/movie/{id}", name="uek_add_demo_paid_order")
	 */
	public function addPaidOrderAction($id)
	{
		if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
			return $this->render('UekUserBundle:Security:please.login.html.twig');
		}
		$user = $this->get('security.token_storage')->getToken()->getUser();
		
		$em = $this->getDoctrine()->getManager();
		$username= $this->get('security.context')->getToken()->getUser();
		$user = $em->getRepository('UekUserBundle:User')->findOneByUsername($username);
		$movie = $em->getRepository('UekMovieBundle:Movie')->findOneById($id);
		if ($user != null && $movie != null && !$movie->isPaidByUser($user))
		{
			$in_progress = $em->getRepository('UekStoreBundle:OrderStatus')->findOneById(OrderStatus::IN_PROGRESS);
			$paid = $em->getRepository('UekStoreBundle:OrderStatus')->findOneById(OrderStatus::PAID);
				
			if ($movie->isOrderedByUser($user))
			{
					foreach($movie->getOrders() as $order)
					{
						if ($order->getUser() == $user)
						{
							$order->setStatus($paid);
						}
					}			
			}
			else 
			{
				$order = new Order ();
				$order->setStatus ( $in_progress );
				$em->persist ( $order );
						
				$order->setUser ( $user );
				$order->addMovie ( $movie );
				
				$order->setStatus($paid);
			}
			$em->flush();
	
    		return $this->redirect($this->generateUrl('uek_movie', array('id' => $movie->getId())));
		}
		 
		return $this->redirect($this->generateUrl('uek_homepage'));
	}
		
	
	/**
	 * @Route("/demo/create/order_statuses", name="uek_create_demo_order_statuses")
	 */
	
	public function createOrderStatusesAction()
	{
		$em = $this->getDoctrine()->getManager();
		$ostatuses = $em->getRepository('UekStoreBundle:OrderStatus')->findAll();
		if (count($ostatuses) == 0)
		{
			$status_list = [
					['id' => OrderStatus::IN_PROGRESS, 'name' => 'In progress'],
					['id' => OrderStatus::PAID, 'name' => 'Paid']	];
			
			foreach ($status_list as $status)
			{
				$ostatus = new OrderStatus();
				$ostatus->setId($status['id']);
				$ostatus->setName($status['name']);
				$em->persist($ostatus);
			}
			
			$em->flush();
		}
		
		return $this->redirect($this->generateUrl('uek_homepage'));
	}
}
