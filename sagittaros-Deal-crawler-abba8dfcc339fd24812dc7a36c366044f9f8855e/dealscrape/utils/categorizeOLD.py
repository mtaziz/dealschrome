def determine_category(input):
    input = tokenize(input)
    scores = {
        'food' : len(input & food()),
        'entertainment' : len(input & entertainment()),
        'travel' : len(input & travel()),
        'beauty' : len(input & beauty()),
        'goods and services' : len(input & goodsnservices()),
    }
    category = max(scores.iterkeys(), key=lambda k: scores[k])
    if scores[category] < 2:
        category = 'others'
    return category

def tokenize(input):
    output = set(input.lower().split(' '))
    if '' in output:
        output.remove('')
    return output
    
def food():
    list = 'alcohol appetizer appetizers aroma bar bbq beef beer biscuit biscuits bolognese bolognaise bistro bread breakfast brewed brunch buffet buffets burger burgers cafe cake cakes champagne chef cheese cheesy cheesecake cheesecakes cheese-cake cheese-cakes chicken chickens chinese chips chocolate chocolates club cod coffee cook cookie cookies cooking cooks crab cream creamy cuisine cuisines cupcake delicious dessert desserts diet dine dining dinner dish dishes drink duck ducks durian durians eat egg eggs feast feasts fillet fillets fine fish fishes flavour flavours flow food free french fresh fried fruit fruits garlic gelato grill grilled halal heavenly high hot hotpot hungry ice ice-cream indian ingredient ingredients italian italian japanese juicy lamb lobster lunch main course marinate masala meal meat menu menus mooncake mooncakes mouthwatering mouth-watering msg pancake pancakes pasta pastas pastries pastry pizza pizzas platter platters portuguese prawn prawns indulge indulgence pub ramen recipe recipeschocolate red refreshing restaurant restaurants rice roast salmon sashimi savour savoury scoop seafood snacks shrimp spicy steak steakhouse steaks style sumptuous supper sushi sweet sweets tart tarts tea thai toast vegetable vegetables vegetarian western wine wines yogurt'
    collections = set(list.lower().split(' '))
    if '' in collections:
        collections.remove('')
    return collections
    
def entertainment():
    list = 'admission adrenaline adventure adventures amusement arcade art attraction attractions award ballet bay beach beaches bird birdpark boat bowling bungee cable camp campfire camps car casino celebrities celebrity children city class classes climbing coaster coasters cycling dance dances dive divingf1 drama duck ducktour ducktours entertaining entries entry excitement exercise experience extreme family fee fishing flyer forest fountain fun galleries gallery garden gardens golf grand hill hills hip hippobus hop jet jog jogging jump ladies lagoon lake lakes latin luge marina modern mountain mountains movie movies museum museums nature night nightlife paintball park parks parties party play plays prix production productions race racing reserve reservoir resort ride rides riding roller rollerblade rollerblades rollerblading rollercoaster rollercoasters run running rush contemporary salsa sands scuba segway segways senior sentosa session sessions shiok show singapore skating ski snorkeling snow snowboard snowboarding sport sports stage studios surfing theatre theatres theme thrill ticket tours tracking universal walk walking water waterfall wildlife winning zoo'
    collections = set(list.lower().split(' '))
    if '' in collections:
        collections.remove('')
    return collections
    
def travel():
    list = '1d 1d1n 2d 2d1n 3-star 3d 3d2n 4-star 4d 4d3n 5-star 5d4n 5dfrance 6d5n accommodation accommodations adventure adventureair agency agent agents air airasia airport airline airlines airways apartment asean asia asian association attraction attractions autumn bali bangkok batam bay beach beaches bedroom bintan bookings cambodia cebu chan chiang china coach coaches couple culture day days delux deluxe departure destination destinations dive diving enjoy enjoying europe exciting exclusivity executive exterior family filled fine firefly flight flights garuda getaway getaways global guest guestsone guide haven heaven hike holiday holidays home honeymoon hotel hotels iata indonesia inn interior island italy jakarta japan jetblue johor kid kids korea krabi laos lombok luxurious luxury mai malacca malaysia manila market medan monument motel mountain nam natas national new night nights ocean pacific passport passports penang philippines phuket plaza pool proximity qantas quality relax relaxation relaxing religion residence residences resort resorts restaurants retreat retreats return river romantic sandy scuba sea shanghai shop shopping shuttle sia silkair singapore snorkeling souvenir souvenirs spa spas spring summer surabaya room taiwan temple thai thailand ticket tiger tour tourism tourist tours tradition traditional transfer transfers transport travel trip trips tune ubin vietnam villa virgin visa waterfall white winter york'
    collections = set(list.lower().split(' '))
    if '' in collections:
        collections.remove('')
    return collections
    
def beauty():
    list = 'aesthetic anti-aging arm armpit aroma aromatherapy athletic back bath beautiful beauty bikini blow blowdry body botox bra brand brands brazilian breast bright bushy care cell cells chiropractic clean cleaning cleanser clinic clinics coach collagen color colors colour colours comfort complexion complexions cosmetic cosmetics cozy cream cut deep dehydrating detox diagnosis diet discoloration discomfort double dry enhancer enzyme enzymes exercise extract extracts eye eye-liner eyebrow eyelid eyelids eyes face facial facilities fat figure figures fit fitness foam foot fresh full groomed grooming gym hair hair color hair coloring hair cut hair dressing handcare head health homeopathic hydrating ingredient ingredients keep fit korea korean lacquer leg length lengths lipstick lipsticks make-up makeup mani manicure mascara mask massage moisture moisturizing moustache muscle muscles nail nails neck nourishing nutrient nutrients oil oiliness oily old oxygen ozone package packages pain pamper pampering pampers pedi pedicure pimple polish pore pores powder product products professional professionals proteins radiant refreshes refreshing refreshment rejuvenation relax relaxation remedies removal remover renewal rich salon scalp scrub scrubs sensitive service shave shine shiny shoulder sick silky skin skincare slender slim slimming smoothness soothing sore spa spas strained stress style styles styling sunburn suntanning tanned tanning tatoo tattoo teeth therapist therapy threading tissue tissues tone toned toner treatment treatments tummy vernis vitamin vitamins wash wax waxing wellness whitening wrinkles x-ray young'
    collections = set(list.lower().split(' '))
    if '' in collections:
        collections.remove('')
    return collections

def goodsnservices():
    list = 'ericsson alluminium light portable screen battery bracelet necklace pendants jewellery sparkle sparkling gold silver plated earrings crystals crystal loop 18k leather car camera sony panasonic blackberry dell acer wifi wi-fi tyre tyres polishing tailored shirt ipad ipad2 iphone 4s cover Samsung Philip Philips Google Apple Nokia HTC Asus Gigabyte touchpad harddisks harddisk lcd dvd harvey norman swivel courts ram sony earphone android casing casings glow glowing case bag warranty LED delivery postage registered mail gadget cleaning vacuum cleaner customized personalized GB gb ipod nano touch pen pendrive thumbdrive hello kitty cute goods screen leather screen protector privacy handcraft handcrafted aircon air-con cool aircool cute hamper dog grooming pet ticking de-ticking earring rings sleek diamond pillow accessories ultimate air fryer airfyer angry bird angrybird wood macbook gift present shoes fashion cloth clothing clothes dash board android ios delivery post postage'
    collections = set(list.lower().split(' '))
    if '' in collections:
        collections.remove('')
    return collections    
