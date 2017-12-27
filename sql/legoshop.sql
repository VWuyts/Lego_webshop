-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 27, 2017 at 07:27 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `legoshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `addressID` int(10) UNSIGNED NOT NULL,
  `street` varchar(50) NOT NULL,
  `hNumber` varchar(8) NOT NULL,
  `box` varchar(8) DEFAULT NULL,
  `postalCode` varchar(8) NOT NULL,
  `city` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`addressID`, `street`, `hNumber`, `box`, `postalCode`, `city`, `country`) VALUES
(4, 'Legostraat', '10', '', '336699', 'Legostad', 'Legoland'),
(6, 'Lange Straat', '235', '001', '2680', 'Sint-Katelijne-Waver', 'Belgium'),
(7, 'Schapestraat', '112', '', '26891', 'Dorpje', 'The Netherlands'),
(8, 'ergens', '124', '', '258sd', 'Meerhout', 'Belgium'),
(9, 'Schapestraat', '10', '', '4587', 'Meerhout', 'The Netherlands'),
(10, 'Rue Chateau', '1', '', '8597', 'Houffalize', 'Belgium'),
(11, 'Wolk', '1', '', '10000', 'Hemel', 'Belgium');

-- --------------------------------------------------------

--
-- Table structure for table `customeraddress`
--

CREATE TABLE `customeraddress` (
  `custAddressID` int(10) UNSIGNED NOT NULL,
  `userID` int(10) UNSIGNED NOT NULL,
  `addressID` int(10) UNSIGNED NOT NULL,
  `isInvoice` tinyint(1) NOT NULL DEFAULT '1',
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `tao` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customeraddress`
--

INSERT INTO `customeraddress` (`custAddressID`, `userID`, `addressID`, `isInvoice`, `isActive`, `tao`) VALUES
(3, 5, 4, 1, 1, NULL),
(5, 5, 6, 0, 1, NULL),
(8, 5, 9, 0, 1, 'Mieke Haine'),
(9, 6, 10, 1, 1, NULL),
(10, 7, 11, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `label`
--

CREATE TABLE `label` (
  `labelID` int(10) UNSIGNED NOT NULL,
  `lName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `label`
--

INSERT INTO `label` (`labelID`, `lName`) VALUES
(1, 'Exclusives'),
(2, 'Hard to find'),
(3, 'New');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

CREATE TABLE `orderdetail` (
  `orderno` int(10) UNSIGNED NOT NULL,
  `productno` mediumint(5) UNSIGNED NOT NULL,
  `quantity` tinyint(3) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderdetail`
--

INSERT INTO `orderdetail` (`orderno`, `productno`, `quantity`) VALUES
(3, 40154, 1),
(3, 40155, 1),
(6, 10743, 1),
(6, 40161, 1),
(7, 10220, 1),
(7, 10232, 1),
(9, 40154, 1),
(9, 853465, 3),
(12, 71040, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderno` int(10) UNSIGNED NOT NULL,
  `orderDate` date NOT NULL,
  `userID` int(10) UNSIGNED NOT NULL,
  `isPayed` tinyint(1) NOT NULL DEFAULT '0',
  `orderStatus` enum('processing','shipped','delivered') NOT NULL,
  `invoiceAddressID` int(10) UNSIGNED NOT NULL,
  `shipAddressID` int(10) UNSIGNED NOT NULL,
  `shipCostID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderno`, `orderDate`, `userID`, `isPayed`, `orderStatus`, `invoiceAddressID`, `shipAddressID`, `shipCostID`) VALUES
(3, '0000-00-00', 5, 1, 'processing', 3, 8, 2),
(6, '0000-00-00', 5, 1, 'processing', 3, 5, 1),
(7, '0000-00-00', 6, 1, 'processing', 9, 9, 6),
(8, '0000-00-00', 6, 1, 'processing', 9, 9, 6),
(9, '0000-00-00', 5, 1, 'processing', 3, 3, 11),
(10, '0000-00-00', 5, 1, 'processing', 3, 3, 11),
(11, '0000-00-00', 5, 1, 'processing', 3, 5, 1),
(12, '0000-00-00', 5, 1, 'processing', 3, 5, 6);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productno` mediumint(7) UNSIGNED NOT NULL,
  `pName` varchar(50) NOT NULL,
  `price` decimal(6,2) UNSIGNED NOT NULL,
  `minAge` tinyint(2) UNSIGNED NOT NULL DEFAULT '4',
  `description` text NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `category` enum('sets','extras') NOT NULL,
  `pieces` smallint(5) UNSIGNED DEFAULT NULL,
  `themeID` int(10) UNSIGNED DEFAULT NULL,
  `sortID` int(10) UNSIGNED DEFAULT NULL,
  `labelID` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productno`, `pName`, `price`, `minAge`, `description`, `isActive`, `category`, `pieces`, `themeID`, `sortID`, `labelID`) VALUES
(10220, 'Volkswagen T1 Camper Van', '99.99', 16, 'This authentic camper van is a replica of the classic Volkswagen Camper Van from 1962. Every iconic feature is here! On the outside, the terrific detailing includes \'V\' shape three-way color split at the front, rounded roof and window frames, opening \'splittie\' safari windshield, opening doors, iconic pop-up roof with textile curtain surround, roof rack, rear side air intake vents and lots more! The detailing is equally impressive on the inside, from the authentic VW air-cooled flat four cylinder boxer engine, front cabin bench seat, gear stick, angled dashboard and iconic spherical speedometer, to custom LEGO features like folding rear bench seat, folding dinette table, closet with mirror and even a painting!', 1, 'sets', 1334, 4, 5, 2),
(10232, 'Palace Cinema', '139.99', 16, 'It\'s premiere night at the Palace Cinema! Illuminate the night sky with the spotlights as the child star arrives in a fancy black limousine! Gather the crowd on the star-studded sidewalk, then head into the detailed lobby with a concession stand and ticket area! Take the grand staircase into the theater with a large screen, movie projector and reclining chairs for 6 minifigures. Introducing the latest addition to the LEGO Modular Buildings series, the highly detailed, 2-story Palace Cinema corner building. This collectible model features a sidewalk of the stars, brick-built entrance doors, posters, sign frontage, a tower with spires and rooftop decorations. Includes 6 minifigures: child actress, chauffeur, female guest, male guest, photographer and cinema worker.', 1, 'sets', 2194, 4, 1, 2),
(10234, 'Sidney Opera House', '299.99', 16, 'Recreate one of the 20th century\'s most distinctive buildings with the Sydney Opera House model. Build the unmistakable shell roofline, waterfront forecourt and more with this authentic representation of Australia\'s most iconic building. Employ a variety of new and advanced building techniques to recreate the complex forms, angled walls and subtle detailing of the real thing! Collect lots of dark tan LEGO bricks including the rare 1x1x2/3 stud and 1x2x2/3 stud slopes, as well as a 48x48 stud baseplate in blue for the very first time!', 0, 'sets', 2989, 4, 1, NULL),
(10243, 'Parisian Restaurant', '159.99', 16, 'It\'s very busy in the Parisian Restaurant! As a scooter zips by, inside the waiter rushes between the tables as the nervous young man gets ready to propose with the ring! It\'s just as hectic behind the scenes, with the chef busily preparing the food. This beautifully detailed building is the setting for so many stories and is a great addition to the modular building series. The Parisian Restaurant has a fully-stocked, blue and white tiled kitchen with tableware as well as a cozy apartment with pull-down bed, kitchenette and fireplace. On the top floor is the artist\'s room with a studio that includes a cast iron heater, easel, paintbrush and two works of art by the aspiring artist. Outside, stairs lead down to the roof terrace lined with hanging lanterns and flowers where the diners eat alfresco-style. This amazing Parisian Restaurant model even includes a facade with croissants, clams and feather details that recapture the feel of Paris. Includes 5 minifigures: chef, waiter, girl and a romantic couple.', 1, 'sets', 2469, 4, 1, 2),
(10246, 'Detective\'s Office', '159.99', 16, 'Discover a world of mystery and adventure with the LEGO Creator Expert Detective\'s Office! Step through the open archway and into the barbershop, where seated customers are pampered in the reflection of a large wall mirror, while next door, competitors play pool and darts beneath the comforting whir of a rotating ceiling fan. Venture to the first floor and you\'ll find the detective\'s office, his desk strewn with clues, a safe containing valuable evidence and a concealed wall compartment. Then visit the adjacent bathroom, featuring a classic pull-chain toilet, before taking the stairway to the well-equipped kitchen, from where you can access the roof terrace, complete with large water tower. This latest addition to the LEGO Modular Building series is packed with unsurpassed detail and hidden surprises. Easy-to-remove roof and ceilings provide access to the delightful interior, while the exterior of the building features a decorative roofline and a beautifully designed facade. Can you solve the smuggling mystery? Includes 6 minifigures with assorted accessories: Detective Ace Brickman, Al the barber, dart player, pool player, police woman and a mysterious lady in red.', 1, 'sets', 2262, 4, 1, 2),
(10248, 'Ferrari F40', '89.99', 14, 'Get up close to one of the world\'s greatest supercars—the Ferrari F40! This awesome LEGO Creator Expert replica of the iconic sports car with its sleek aerodynamic lines, distinctive rear spoiler and racing-red bodywork is packed with authentic brick-built details, including pop-up headlights, side air intakes and a vented rear hatch that opens to reveal a twin-turbocharged, 90-degree V8 engine! Open the doors and you\'ll discover complete authenticity, right down to the crafted cabled door handles, steering wheel with Ferrari logo and 2 red racing seats, while under the hood you\'ll find a luggage compartment and tools. A special windscreen element with printed A-pillars and custom-made, molded rim inserts with sturdy, road-gripping tires add the final touches to this intricately designed model, a must-have for all Ferrari fans!', 1, 'sets', 1158, 4, 3, 2),
(10249, 'Winter Toy Shop', '79.99', 12, 'Welcome to the Winter Toy Shop! The holiday season has arrived and the toymaker is busy finishing off his latest creations! Outside, children ski and snowboard, and a freshly built snowman sparkles in the light that shines from the toyshop tower. Help decorate the huge tree that stands at the center of the square, play with the curious kitten on the cozy wooden bench or join in with the carolers beneath the ornate streetlamp. This charming set also features a ladder, trees in various sizes, jack-in-the-box, a toy biplane, helicopter, rocket, train, race car, truck, robot, tugboat, teddy bear and a wrapped gift. Have fun building this enchanting winter wonderland! Includes a snowman and 8 minifigures with assorted accessories: a male caroler, female caroler, a woman, 2 men, 2 boys and a girl.', 1, 'sets', 898, 2, 1, 2),
(10251, 'Brick Bank', '169.99', 16, 'Make a secure deposit at the highly respected Brick Bank, featuring an array of intricate details and hidden surprises. Easy-to-remove building sections provide access to the detailed interior, comprising a bank with an atrium foyer, tiled floor, arched windows, ornate chandelier, lockable vault and a transaction counter with security glass; a laundrette with printed window, tiled floor and 4 washing machines; plus 2 second-floor offices with an array of detailed furniture, fixtures and accessories. The exterior of the building features a detailed sidewalk and an elaborate facade with carving and statue decor, decorative roofline, large arched windows, central balcony, clock and an accessible roof terrace featuring a large skylight. Collect and build an entire town with the LEGO Creator Expert Modular Building series 10243 Parisian Restaurant and 10246 Detective\'s Office. Includes 5 minifigures: a bank manager, secretary, cashier, mum and child.', 1, 'sets', 2382, 4, 1, 2),
(10254, 'Winter Holiday Train', '104.99', 12, 'Gather the family for some festive LEGO building fun with this charming model featuring a full circle of track, boarding platform with bench and lamppost, a Power Functions upgradable train engine with brick-built smoke bellowing from its stack, coal tender, flatbed wagon with a rotating holiday tree, toys and gifts, and a red caboose with a detailed interior and table. The train engine also features large and small red-colored locomotive wheels and the train is decorated with green wreathes, string lights and white tree elements. This LEGO Creator Expert set includes 5 minifigures.', 1, 'sets', 734, 2, 8, 1),
(10255, 'Assembly Square', '259.99', 16, 'Take a trip to the amazing Assembly Square, developed to celebrate ten years of LEGO Modular Buildings, featuring a wealth of unsurpassed, intricate details and hidden surprises. Easy-to-remove building sections provide access to the highly detailed interior, comprising a ground level with a bakery, florist\'s shop and café, a middle level with a music store, photo studio and dental office, and an upper-level dance studio and apartment with access to a rooftop terrace with barbecue. The exterior of the building features a detailed sidewalk with outdoor café furniture, fountain, streetlamps and a highly elaborate facade with beautifully detailed windows and doors, three buildable shop signs, spired tower and a decorative roofline. Collect and build an entire town with the LEGO Creator Expert Modular Building series 10243 Parisian Restaurant, 10246 Detective\'s Office and 10251 Brick Bank. Includes eight minifigures and a baby figure.', 1, 'sets', 4002, 4, 1, 2),
(10256, 'Taj Mahal', '349.99', 16, 'Build and discover the Taj Mahal! The huge ivory-white marble mausoleum, renowned as one of the world\'s architectural wonders, was commissioned in 1631 by the Emperor Shah Jahan in memory of his wife, the Empress Mumtaz Mahal. This relaunched 2008 LEGO Creator Expert interpretation features the structure\'s 4 facades with sweeping arches, balconies and arched windows. The central dome, subsidiary domed chambers and surrounding minarets are topped with decorative finials, and the raised platform is lined with recessed arches. The model is finished with ornate detailing throughout and intricate tilework around the base. With more than 5900 pieces, this set is designed to deliver a rewarding building experience and makes a great display piece for the home or office.', 1, 'sets', 5923, 4, 1, 3),
(10258, 'London Bus', '129.99', 16, 'Celebrate iconic design with this charming double-decker London Bus, featuring a wealth of authentic details, including a bright-red color scheme, panoramic windshield, specially made standard-tread tires, destination sign, and an open rear boarding deck with a hand pole, ticket bin, fire extinguisher and a half-spiral staircase that leads to the upper sightseeing deck. Functions include an opening hood with engine, detailed driver\'s cab with a sliding door, and a removable roof and upper deck for access to the detailed interior with worn look seating and additional authentic details, including a forgotten umbrella, newspaper, empty beverage can and discarded chewing gum. Reversible transit advertising posters are also provided as printed labels with a 1950s or present-day London promotion. This LEGO Creator Expert model has been designed to provide a challenging and rewarding building experience with a touch of nostalgia and charm.', 1, 'sets', 1686, 4, 5, 2),
(10259, 'Winter Village Station', '74.99', 12, 'Head for home with the festive Winter Village Station holiday set, featuring a snowy railroad station with wreath adorned lampposts and clock tower, platform, mailbox, green trees, snowy grade crossing with twin barriers and lights, and a beautiful, festively decorated bus with opening doors and a luggage rack with removable luggage and gift wrapped packages. This LEGO Creator Expert model also includes a ticket counter with a timetable and a transaction counter window with room for sliding out tickets to travelers, plus a coffee shop with a serving hatch and a detailed interior with an espresso machine, cups, cash register and a menu. Includes 5 minifigures.', 1, 'sets', 902, 2, 1, 3),
(10743, 'Smokey\'s Garage', '24.99', 4, 'Give Lightning McQueen a service in Smokey\'s Garage after a hard day training on the racetrack. Drive the car up the ramp, change the tires, pick the tool accessories from the cabinet and role-play endless Disney Pixar Cars 3 scenes with this fun LEGO Juniors set. Includes a simple guide to build and play, and bigger pieces help build confidence in younger kids. LEGO Juniors is an age-appropriate build and play experience for ages 4-7. Includes Lightning McQueen, Junior Moon and Smokey LEGO Juniors characters.', 1, 'sets', 166, 5, 3, NULL),
(21026, 'Venice', '24.99', 12, 'Recreate the historic, architectural magnificence of Venice, with this realistic LEGO brick model. The LEGO Architecture Skyline Collection offers models suitable for display in the home and office, and has been developed for all with an interest in travel, architectural culture, history and design. Each set is scaled to give an accurate representation of the comparative size of each structure, with true-to-life color depiction. This set features the Rialto Bridge, St. Mark\'s Basilica, St. Mark\'s Campanile, St. Theodore and the Winged Lion of St. Mark, and the Bridge of Sighs, and is finished with a decorative \'Venice\' nameplate.', 1, 'sets', 212, 1, 1, NULL),
(21027, 'Berlin', '34.99', 12, 'Recreate Berlin\'s blend of historical and modern architecture with this realistic LEGO brick model. The LEGO Architecture Skyline Collection offers models suitable for display in the home and office, and has been developed for all with an interest in travel, architectural culture, history and design. Each set is scaled to give an accurate representation of the comparative size of each structure, with true-to-life color depiction. This set features the Reichstag, Victory Column, Deutsche Bahn Tower, Berlin TV Tower and the Brandenburg Gate, and is finished with a decorative \'Berlin\' nameplate.', 1, 'sets', 289, 1, 1, NULL),
(21034, 'London', '49.99', 12, 'Celebrate the architectural diversity of London with this detailed LEGO brick model. The LEGO Architecture Skyline Collection offers models suitable for display in the home and office, and has been developed for all with an interest in travel, architectural culture, history and design. Each set is scaled to give an accurate representation of the comparative size of each structure, with true-to-life color depiction. This set features the National Gallery, Nelson\'s Column, London Eye, Big Ben (the Elizabeth Tower) and Tower Bridge, and is finished with a decorative \'London\' nameplate.', 1, 'sets', 468, 1, 1, NULL),
(21035, 'Solomon R. Guggenheim Museum', '79.99', 12, 'Discover the architectural secrets of Frank Lloyd Wright\'s Solomon R. Guggenheim Museum. This accurately detailed LEGO model faithfully recreates the curves and distinctive lines that have made this building an architectural icon for the last half-century. The simple, grid-patterned facade of the annex tower complements the main building with its circular rotundas, while buildable exterior elements depict a section of New York City\'s 5th Avenue Museum Mile, complete with its signature yellow cabs. The Guggenheim sign, featuring Wright\'s architectural lettering, has also been recreated in a similar typeface to heighten the authenticity of the model. This LEGO Architecture model has been designed to deliver a rewarding building experience for all with an interest in architecture, travel, history and design, and is suitable for display in the home and office.', 1, 'sets', 744, 1, 1, NULL),
(40154, 'Iconic Pencil Pot', '12.99', 7, 'Build the perfect home for all your stationery with the LEGO Iconic Pencil Pot! Follow the included building instructions to construct this colorful house and then store your pencils, pens, rulers, erasers and more in its 3 rooms. Includes 2 minifigures.', 0, 'extras', 174, NULL, NULL, NULL),
(40155, 'Piggy Coin Bank', '12.99', 7, 'Build the LEGO Iconic Piggy Coin Bank and store your money inside. Drop your coins through the slot and turn the red piggy\'s eyes and posable ears for a variety of cute expressions.', 1, 'extras', 148, NULL, NULL, NULL),
(40161, 'What Am I?', '39.99', 7, 'Play LEGO Iconic What Am I? and ask yes/no questions to guess your opponent\'s minifigure or small build—there are 16 buildable and removable minifigures included with the game, or you can use your own to add to the fun! The game also comes with building instructions and rules for playing, and the handy packaging can be used to store the game between uses.', 1, 'extras', 536, NULL, NULL, NULL),
(40174, 'Lego Iconic Chess Set', '59.99', 9, 'Use classic LEGO bricks to build your own chess board and then build all the playing pieces too. This set is ideal to take and play wherever you like, as the pieces store conveniently inside the board. It can also be used to play checkers.', 1, 'extras', 1450, NULL, NULL, NULL),
(71006, 'The Simpson House', '219.99', 12, 'D\'oh! Recreate hilarious scenes from the classic animated TV series with The Simpsons House. Taken right out of Springfield, this amazing model is crammed with tons of LEGO brick detail. Lift off the roof and open up the house to discover Homer and Marge\'s big family bedroom including bed and Maggie\'s crib, Bart\'s room with his skateboard and Krusty the Clown poster, Lisa\'s room with her favorite books, jazz poster and more, and bathroom with shower, toilet, sink and mirror. Lift off the top floor to reveal the fully-fitted kitchen with dining table, chairs, yellow and light-blue tiled floor and lots of pots, pans and other accessories. Then it\'s into the living room with couch and TV playing Itchy and Scratchy, purple piano and more. Next to the house is the detachable garage, complete with workbench, tool rack, vacuum cleaner, broom, toolbox, tools and the family car, complete with dent (because only in a LEGO world are dents a plus!), opening trunk and \'radioactive\' bar from the nuclear power plant. Step outside onto the terrace and you\'ll find loads of cool items, including a grill, wheelbarrow and air conditioning unit with \'Property of Ned Flanders\' decoration, sausages, 2 garden loungers, flowerpots, a shovel, 2 fruit cocktail glasses, Lisa\'s camera, Bart\'s skateboard ramp with \'El Barto\' graffiti and an antenna on the roof. The Simpsons House is the perfect collector\'s item for fans of all ages. Includes 6 minifigures: Homer, Marge, Bart, Lisa, Maggie and Ned Flanders.', 1, 'sets', 2523, 10, 1, 2),
(71016, 'The Kwik-E-Mart', '219.99', 12, 'Welcome to The Kwik-E-Mart—your one-stop shop for convenience foods at inconvenient prices! This highly detailed and iconic LEGO version of The Simpsons store is packed with more rich, colorful details than a Mr. Burns birthday cake has candles! Walk under the huge Kwik-E-Mart sign and join Homer, Marge and Bart as they browse the aisles filled with beauty products, diapers, dog food, pastries, fruits, vegetables and more—including Krusty-O\'s and Chef Lonelyheart\'s Soup for One. Then head over to the refrigerated cases where you\'ll find Buzz Cola, chocolate milk, various other drinks and snacks… and frozen Jasper! There\'s also a Buzz Cola soda fountain, juice dispensers, coffee machine, arcade games, ATM and stacks of Powersauce boxes. At the counter, Apu is ready to tempt you with a variety of printed magazines, comic books, cards, tofu hot dogs, freshly expired donuts and his ever-popular hallucination-inducing Squishees. At the back, there\'s a storage closet complete with rat and an exit. On the roof you\'ll discover Apu\'s secret vegetable garden, while outside this amazing model features bright-yellow walls, 2 phone booths, a stack of purple crates, and a dumpster area with \'El Barto\' graffiti, opening door and an iconic blue dumpster that also opens. You can also remove the roof and open out the rear walls for easy access. This set also includes Snake (a.k.a. Jailbird), who loves nothing more than stealing cars and robbing the Kwik-E-Mart—but this time Chief Wiggum is hot on his tail in his police car. Capture this bandit and return peace to the town of Springfield and the amazing Kwik-E-Mart. This fantastic set includes 6 minifigures with assorted accessory elements: Homer Simpson, Bart Simpson, Marge Simpson, Apu Nahasapeemapetilon, Chief Wiggum and Snake (a.k.a. Jailbird).', 1, 'sets', 2179, 10, 1, 2),
(71040, 'The Disney Castle', '349.99', 16, 'Bring the magical world of Disney to your home with The Disney Castle. This highly detailed LEGO model with over 4000 pieces offers a rewarding build and play experience, and comes with an array of exciting Disney-themed features and functions. The intricately detailed facade and towers replicate the iconic Walt Disney World Resort Cinderella Castle, and each accessible castle room includes special features inspired by some of Disney\'s greatest animated feature films, providing endless play possibilities with the included minifigures: Mickey Mouse, Minnie Mouse, Donald Duck, Daisy Duck and Tinker Bell, or other characters from your collection.', 1, 'sets', 4080, 5, 1, 1),
(71042, 'Silent Mary', '219.99', 14, 'Bring the magic of Disney\'s Pirates of the Caribbean to your home with this impressive replica of the Silent Mary ghost ship. This highly detailed LEGO model with over 2200 pieces features a hinged bow section, opening skeleton hull with decay and destruction detailing, movable rudder, collapsible main mast and two further masts, long bowsprit with crow\'s nest and mast, tattered sails, detailed quarterdeck, plus a rowboat with two oars and an array of weapons and accessory elements. This model provides a rewarding build and play experience, and the integrated stand makes it suitable for display in the home or office. Also includes eight minifigures: Captain Jack Sparrow, Henry, Carina, Lieutenant Lesaro, Captain Salazar, Officer Magda, Officer Santos and the Silent Mary Masthead, plus two detachable ghost sharks.', 1, 'sets', 2294, 5, 6, 2),
(75159, 'Death Star', '499.99', 16, 'Reenact amazing scenes from the Star Wars saga with the Empire1s ultimate planet-zapping weapon—the Death Star! With over 4000 pieces, this fantastic model has a galaxy of intricate and authentic environments, including a superlaser control room, Imperial conference chamber, hangar bay with moving launch rack and Lord Vader\'s TIE Advanced with space for Vader inside, Emperor Palpatine\'s throne room, Droid maintenance room, detention block, trash compactor, tractor beam, cargo area, turbo laser with spring-loaded shooters and seats for the 2 Death Star Gunners, and 2 movable turbo laser towers. This fantastic set also includes 23 iconic minifigures and 2 Droids to ensure hours of Star Wars battle fun.', 1, 'sets', 4016, 9, 5, 2),
(75192, 'Millennium Falcon', '849.00', 16, 'Welcome to the largest, most detailed LEGO Star Wars Millennium Falcon model we\'ve ever created—in fact, with 7500 pieces it\'s one of our biggest LEGO models, period! This amazing LEGO interpretation of Han Solo\'s unforgettable Corellian freighter has all the details that Star Wars fans of any age could wish for, including intricate exterior detailing, upper and lower quad laser cannons, landing legs, lowering boarding ramp and a 4-minifigure cockpit with detachable canopy. Remove individual hull plates to reveal the highly detailed main hold, rear compartment and gunnery station. This amazing model also features interchangeable sensor dishes and crew, so you decide whether to play out classic LEGO Star Wars adventures with Han, Leia, Chewbacca and C-3PO, or enter the world of Episode VII and VIII with older Han, Rey, Finn and BB-8!', 1, 'sets', 7541, 9, 5, 3),
(75827, 'Firehouse Headquarters', '399.99', 16, 'Recreate iconic Ghostbusters scenes with the 2-storey Firehouse Headquarters, featuring laboratory, living quarters, containment unit and much more. Capture the ghosts with the proton packs and restore order, or solve other supernatural cases! Includes 9 minifigures: Peter Venkman, Raymond Stantz, Egon Spengler, Winston Zeddemore, Janine Melnitz, Dana Barrett, Louis Tully, Library Ghost and Zombie Driver.', 1, 'sets', 4634, 6, 1, 2),
(75828, 'Ecto-1 & 2', '59.99', 8, 'Speed after the demon ghost Mayhem with the Ecto-1 car and Ecto-2 motorbike. Lift the detachable roof off the Ecto-1 to fit the 4 Ghostbusters heroes inside, and place their gear in the rear storage area. Act out paranormal detection with the PKE Meter, place Kevin on the Ecto-2 motorbike or role-play other action-packed scenes from the 2016 Ghostbusters movie. Includes 5 minifigures and a Mayhem figure.', 1, 'sets', 556, 6, 3, NULL),
(75870, 'Chrevolet Corvette Z06', '17.99', 7, 'Hit top speed with this buildable, minifigure-scale LEGO Speed Champions version of a true American icon—the Chevrolet Corvette Z06. The set includes interchangeable wheel trims, racing helmet, wrench and a television camera element, to fire the imagination of budding motor racing fans. Includes a Chevrolet Racing driver minifigure.', 1, 'sets', 173, 8, 3, NULL),
(75871, 'Ford Mustang GT', '17.99', 7, 'Power across the desert with this buildable, minifigure-scale LEGO Speed Champions version of the American muscle car famous for its V8 engine—the Ford Mustang GT. Play out different race-day scenarios with this set that features interchangeable wheel trims, a wrench and a timing-board element. Includes a Ford racing driver minifigure.', 1, 'sets', 185, 8, 3, NULL),
(75872, 'Audi R18 e-tron quattro', '17.99', 7, 'Fuel racing dreams with this LEGO Speed Champions version of one of the most successful track cars of all time. This buildable, minifigure-scale version of the Audi R18 e-tron quattro comes with interchangeable wheel trims, wrench and a fuel pump element. Includes an Audi racing driver minifigure.', 1, 'sets', 166, 8, 3, NULL),
(75880, 'McLaren 720S', '17.99', 7, 'Become a supercar designer and racing driver with the buildable LEGO Speed Champions version of the McLaren 720S plus design studio. This buildable car features loads of authentic details and comes with a design desk and play-starting elements, including an original design sketch and printed 3D miniature version of the McLaren 720S. Also includes one minifigure.', 1, 'sets', 161, 8, 3, NULL),
(853465, 'Upscaled Mug', '9.99', 5, 'Imagine that you\'re part of the LEGO universe when you have a drink from this life-sized LEGO mug! This blue plastic mug is more than 10 times larger than the ones you find in your LEGO sets and perfect for when you need to take a break from building. Collect several mugs and stack them for easy storage.', 1, 'extras', NULL, NULL, NULL, NULL),
(853470, 'Star Wars R2-D2 Keyring', '4.99', 6, 'Turn every trip into an exciting adventure with this LEGO Star Wars R2-D2 Key Chain. Attach it to your keys or backpack using the durable key ring and chain and let this pint-size Astromech Droid bring a smile to your face wherever you go.', 1, 'extras', NULL, 9, NULL, NULL),
(853569, 'Lego Notebook with Studs', '9.99', 6, 'Write, draw and build with this sturdy notebook, featuring a hardback cover with a 5x24-stud baseplate and 60 1x1 flat tiles in various colors. Customize your notebook with mosaics, letters or numbers and use the supplied page marker ribbon to mark your favorite pages. Makes a great gift for fans of LEGO building sets.', 1, 'extras', 60, NULL, NULL, NULL),
(853575, 'Minifigure Cake Mold', '14.99', 3, 'Have a party and bring out the coolest cake in town! Bake up a tasty treat in one of your favorite LEGO shapes with this easy to use, easy to remove silicone baking mold that can be used in both the oven and microwave, and cleans up quickly in the dishwasher. Bring a minifigure to life with this fun cake mold!', 1, 'extras', NULL, NULL, NULL, NULL),
(853669, 'Lego Shopper Bag', '5.99', 3, 'Say goodbye to disposable carrier bags with this large reusable LEGO Shopper Bag, produced in a sturdy, non-woven laminated fabric printed with a colorful LEGO brick design. This environmentally friendly bag is built to last, with plenty of room for your next LEGO shopping trip.', 1, 'extras', NULL, NULL, NULL, NULL),
(2856080, 'Star Wars Stormtrooper Minifigure Clock', '29.99', 6, 'Celebrate the Star Wars saga around the clock with the LEGO Star Wars Stormtrooper Minifigure Clock. The perfect addition to every LEGO Star Wars collection, this menacing decor features a digital, lighted display and alarm clock. A great gift for any LEGO Star Wars fan.', 1, 'extras', NULL, 9, NULL, NULL),
(2856081, 'Star Wars Darth Vader Minifigure Clock', '29.99', 7, 'Feel the power of the dark side at home with the LEGO Star Wars Darth Vader Minifigure Clock. The perfect addition to every LEGO Star Wars collection, this menacing decor features a digital, lighted display and alarm clock. A great gift for any LEGO Star Wars fan.', 1, 'extras', NULL, 9, NULL, NULL),
(5004264, 'Lego 1x2 Brick key Light (Red)', '8.99', 5, 'Light the way to all your building adventures with the iconic red LEGO 1x2 Brick Key Light. Sturdy metal ring makes this super-bright, LED flashlight a great backpack charm, or keeps it secure on your key chain. Features an easy-to-turn-on-and-off momentary switch. Makes a great gift for LEGO fans!', 1, 'extras', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `registereduser`
--

CREATE TABLE `registereduser` (
  `userID` int(10) UNSIGNED NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passw` char(64) NOT NULL,
  `role` enum('admin','customer') NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `registereduser`
--

INSERT INTO `registereduser` (`userID`, `firstname`, `surname`, `email`, `passw`, `role`, `isActive`) VALUES
(5, 'Nik', 'Wuyts', 'nik@legoshop.com', '12868fe31691f647982237a6b241f5a0bd606faf82ffb78e5ae3935250211a81', 'admin', 1),
(6, 'Bert', 'Bakker', 'bert@mail.com', '7d771efe20ce244c965515d8c832a6e82d54170561d23534733039e08431d1e3', 'customer', 1),
(7, 'Sint', 'Nikolaas', 'sinterklaas@hemelmail.eu', '3e04fdbd98b2a5fb47dac1b5fffd80814048ef8af1b88237b4cbf54043aa27b0', 'customer', 0);

-- --------------------------------------------------------

--
-- Table structure for table `shippingcost`
--

CREATE TABLE `shippingcost` (
  `costID` int(10) UNSIGNED NOT NULL,
  `amount` decimal(5,2) NOT NULL,
  `minPurchase` decimal(6,2) NOT NULL DEFAULT '0.00',
  `country` varchar(50) NOT NULL DEFAULT 'België'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shippingcost`
--

INSERT INTO `shippingcost` (`costID`, `amount`, `minPurchase`, `country`) VALUES
(1, '5.95', '0.00', 'Belgium'),
(2, '5.95', '0.00', 'The Netherlands'),
(3, '5.95', '0.00', 'Luxembourg'),
(4, '5.95', '0.00', 'Germany'),
(5, '5.95', '0.00', 'France'),
(6, '0.00', '50.00', 'Belgium'),
(7, '0.00', '50.00', 'The Netherlands'),
(8, '0.00', '50.00', 'Luxembourg'),
(9, '0.00', '50.00', 'Germany'),
(10, '0.00', '50.00', 'France'),
(11, '0.00', '0.00', 'Legoland');

-- --------------------------------------------------------

--
-- Table structure for table `sort`
--

CREATE TABLE `sort` (
  `sortID` int(10) UNSIGNED NOT NULL,
  `sName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sort`
--

INSERT INTO `sort` (`sortID`, `sName`) VALUES
(2, 'Boats'),
(1, 'Buildings'),
(3, 'Cars'),
(4, 'Fantasy'),
(5, 'Other vehicles'),
(6, 'Pirates'),
(7, 'Robotics'),
(8, 'Trains');

-- --------------------------------------------------------

--
-- Table structure for table `theme`
--

CREATE TABLE `theme` (
  `themeID` int(10) UNSIGNED NOT NULL,
  `tName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `theme`
--

INSERT INTO `theme` (`themeID`, `tName`) VALUES
(1, 'Architecture'),
(2, 'Christmas'),
(3, 'City'),
(4, 'Creator Expert'),
(5, 'Disney'),
(6, 'Ghostbusters'),
(7, 'MINDSTORMS'),
(8, 'Speed Champions'),
(9, 'Star Wars'),
(10, 'The Simpsons');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`addressID`);

--
-- Indexes for table `customeraddress`
--
ALTER TABLE `customeraddress`
  ADD PRIMARY KEY (`custAddressID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `addressID` (`addressID`);

--
-- Indexes for table `label`
--
ALTER TABLE `label`
  ADD PRIMARY KEY (`labelID`),
  ADD UNIQUE KEY `lName` (`lName`);

--
-- Indexes for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD PRIMARY KEY (`orderno`,`productno`),
  ADD KEY `productno` (`productno`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderno`),
  ADD KEY `userID` (`userID`),
  ADD KEY `invoiceAddressID` (`invoiceAddressID`),
  ADD KEY `shipAddressID` (`shipAddressID`),
  ADD KEY `shipCostID` (`shipCostID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productno`),
  ADD UNIQUE KEY `pName` (`pName`),
  ADD KEY `themeID` (`themeID`),
  ADD KEY `sortID` (`sortID`),
  ADD KEY `labelID` (`labelID`);

--
-- Indexes for table `registereduser`
--
ALTER TABLE `registereduser`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `shippingcost`
--
ALTER TABLE `shippingcost`
  ADD PRIMARY KEY (`costID`);

--
-- Indexes for table `sort`
--
ALTER TABLE `sort`
  ADD PRIMARY KEY (`sortID`),
  ADD UNIQUE KEY `sName` (`sName`);

--
-- Indexes for table `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`themeID`),
  ADD UNIQUE KEY `tName` (`tName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `addressID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `customeraddress`
--
ALTER TABLE `customeraddress`
  MODIFY `custAddressID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `label`
--
ALTER TABLE `label`
  MODIFY `labelID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderno` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `registereduser`
--
ALTER TABLE `registereduser`
  MODIFY `userID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `shippingcost`
--
ALTER TABLE `shippingcost`
  MODIFY `costID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `sort`
--
ALTER TABLE `sort`
  MODIFY `sortID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `theme`
--
ALTER TABLE `theme`
  MODIFY `themeID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `customeraddress`
--
ALTER TABLE `customeraddress`
  ADD CONSTRAINT `customeraddress_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `registereduser` (`userID`),
  ADD CONSTRAINT `customeraddress_ibfk_2` FOREIGN KEY (`addressID`) REFERENCES `address` (`addressID`);

--
-- Constraints for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD CONSTRAINT `orderdetail_ibfk_1` FOREIGN KEY (`orderno`) REFERENCES `orders` (`orderno`),
  ADD CONSTRAINT `orderdetail_ibfk_2` FOREIGN KEY (`productno`) REFERENCES `product` (`productno`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `registereduser` (`userID`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`invoiceAddressID`) REFERENCES `customeraddress` (`custAddressID`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`shipAddressID`) REFERENCES `customeraddress` (`custAddressID`),
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`shipCostID`) REFERENCES `shippingcost` (`costID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`themeID`) REFERENCES `theme` (`themeID`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`sortID`) REFERENCES `sort` (`sortID`),
  ADD CONSTRAINT `product_ibfk_3` FOREIGN KEY (`labelID`) REFERENCES `label` (`labelID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
