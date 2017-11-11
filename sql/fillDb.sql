/*
	Lego Webshop
	
	Lab assignment for course PHP & MySQL 2017
	Thomas More campus De Nayer
	Bachelor Elektronica-ICT -- Application Development
	
	Véronique Wuyts
 */

/* Database Legoshop */
USE Legoshop;

/* Fill table theme */
INSERT INTO theme (tName)
VALUES  ("Architecture"),
        ("Christmas"),
        ("City"),
        ("Creator Expert"),
        ("Disney"),
        ("Ghostbusters"),
        ("MINDSTORMS"),
        ("Speed Champions"),
        ("The Simpsons")
;

/* Fill table sort */
INSERT INTO sort (sName)
VALUES  ("Buildings"), --1
        ("Boats"), --2
        ("Cars"),--3
        ("Fantasy"), --4
        ("Robotics"), --5
        ("Trains") --6
;

/* Fill table label */
INSERT INTO label (lName)
VALUES  ("Exclusive"),
        ("Hard to find"),
        ("New")
;

/* Fill table product with building sets without label */
INSERT INTO product
    (productno, pName, price, minAge, description, isActive, category, pieces, theme, sort)
VALUES  ()
;

/* Fill table product with building sets with label */
INSERT INTO product
    (productno, pName, price, minAge, description, isActive, category, pieces, theme, sort, label)
VALUES  (71006, "The Simpson House", 219.99, 12, "D'oh! Recreate hilarious scenes from the classic animated TV series with The Simpsons House. Taken right out of Springfield, this amazing model is crammed with tons of LEGO brick detail. Lift off the roof and open up the house to discover Homer and Marge's big family bedroom including bed and Maggie's crib, Bart's room with his skateboard and Krusty the Clown poster, Lisa's room with her favorite books, jazz poster and more, and bathroom with shower, toilet, sink and mirror. Lift off the top floor to reveal the fully-fitted kitchen with dining table, chairs, yellow and light-blue tiled floor and lots of pots, pans and other accessories. Then it's into the living room with couch and TV playing Itchy and Scratchy, purple piano and more. Next to the house is the detachable garage, complete with workbench, tool rack, vacuum cleaner, broom, toolbox, tools and the family car, complete with dent (because only in a LEGO world are dents a plus!), opening trunk and 'radioactive' bar from the nuclear power plant. Step outside onto the terrace and you'll find loads of cool items, including a grill, wheelbarrow and air conditioning unit with 'Property of Ned Flanders' decoration, sausages, 2 garden loungers, flowerpots, a shovel, 2 fruit cocktail glasses, Lisa's camera, Bart's skateboard ramp with 'El Barto' graffiti and an antenna on the roof. The Simpsons House is the perfect collector's item for fans of all ages. Includes 6 minifigures: Homer, Marge, Bart, Lisa, Maggie and Ned Flanders.", 
            1, "sets", 2523, 9, 1, 2),
        (71016, "The Kwik-E-Mart", 219.99, 12, "Welcome to The Kwik-E-Mart—your one-stop shop for convenience foods at inconvenient prices! This highly detailed and iconic LEGO version of The Simpsons store is packed with more rich, colorful details than a Mr. Burns birthday cake has candles! Walk under the huge Kwik-E-Mart sign and join Homer, Marge and Bart as they browse the aisles filled with beauty products, diapers, dog food, pastries, fruits, vegetables and more—including Krusty-O's and Chef Lonelyheart's Soup for One. Then head over to the refrigerated cases where you'll find Buzz Cola, chocolate milk, various other drinks and snacks… and frozen Jasper! There's also a Buzz Cola soda fountain, juice dispensers, coffee machine, arcade games, ATM and stacks of Powersauce boxes. At the counter, Apu is ready to tempt you with a variety of printed magazines, comic books, cards, tofu hot dogs, freshly expired donuts and his ever-popular hallucination-inducing Squishees. At the back, there's a storage closet complete with rat and an exit. On the roof you'll discover Apu's secret vegetable garden, while outside this amazing model features bright-yellow walls, 2 phone booths, a stack of purple crates, and a dumpster area with 'El Barto' graffiti, opening door and an iconic blue dumpster that also opens. You can also remove the roof and open out the rear walls for easy access. This set also includes Snake (a.k.a. Jailbird), who loves nothing more than stealing cars and robbing the Kwik-E-Mart—but this time Chief Wiggum is hot on his tail in his police car. Capture this bandit and return peace to the town of Springfield and the amazing Kwik-E-Mart. This fantastic set includes 6 minifigures with assorted accessory elements: Homer Simpson, Bart Simpson, Marge Simpson, Apu Nahasapeemapetilon, Chief Wiggum and Snake (a.k.a. Jailbird).", 
            1, "sets", 2179, 9, 1, 2),
        (10259, "Winter Village Station", 74.99, 12, "Head for home with the festive Winter Village Station holiday set, featuring a snowy railroad station with wreath adorned lampposts and clock tower, platform, mailbox, green trees, snowy grade crossing with twin barriers and lights, and a beautiful, festively decorated bus with opening doors and a luggage rack with removable luggage and gift wrapped packages. This LEGO Creator Expert model also includes a ticket counter with a timetable and a transaction counter window with room for sliding out tickets to travelers, plus a coffee shop with a serving hatch and a detailed interior with an espresso machine, cups, cash register and a menu. Includes 5 minifigures.", 
            1, "sets", 902, 2, 1, 3),
        (10254, "Winter Holiday Train", 104.99, 12, "Gather the family for some festive LEGO building fun with this charming model featuring a full circle of track, boarding platform with bench and lamppost, a Power Functions upgradable train engine with brick-built smoke bellowing from its stack, coal tender, flatbed wagon with a rotating holiday tree, toys and gifts, and a red caboose with a detailed interior and table. The train engine also features large and small red-colored locomotive wheels and the train is decorated with green wreathes, string lights and white tree elements. This LEGO Creator Expert set includes 5 minifigures.", 
            1, "sets", 734, 2, 6, 1),
        (10255, "Assembly Square", 259.99, 16, "Take a trip to the amazing Assembly Square, developed to celebrate ten years of LEGO Modular Buildings, featuring a wealth of unsurpassed, intricate details and hidden surprises. Easy-to-remove building sections provide access to the highly detailed interior, comprising a ground level with a bakery, florist's shop and café, a middle level with a music store, photo studio and dental office, and an upper-level dance studio and apartment with access to a rooftop terrace with barbecue. The exterior of the building features a detailed sidewalk with outdoor café furniture, fountain, streetlamps and a highly elaborate facade with beautifully detailed windows and doors, three buildable shop signs, spired tower and a decorative roofline. Collect and build an entire town with the LEGO Creator Expert Modular Building series 10243 Parisian Restaurant, 10246 Detective's Office and 10251 Brick Bank. Includes eight minifigures and a baby figure.", 
            1, "sets", 4002, 4, 1, 2),
        (10256, "Taj Mahal", 349.99, 16, "Build and discover the Taj Mahal! The huge ivory-white marble mausoleum, renowned as one of the world's architectural wonders, was commissioned in 1631 by the Emperor Shah Jahan in memory of his wife, the Empress Mumtaz Mahal. This relaunched 2008 LEGO Creator Expert interpretation features the structure's 4 facades with sweeping arches, balconies and arched windows. The central dome, subsidiary domed chambers and surrounding minarets are topped with decorative finials, and the raised platform is lined with recessed arches. The model is finished with ornate detailing throughout and intricate tilework around the base. With more than 5900 pieces, this set is designed to deliver a rewarding building experience and makes a great display piece for the home or office.", 
            1, "sets", 5923, 4, 1, 3)
;