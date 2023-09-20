<?php

namespace App\Models;

use PDOException;

class DatabaseModel
{
    private $dbName;
    private $dbUser;
    private $dbPassword;
    private $dbHost = 'localhost';
    private $dbPort = '5432';
    private $tablePrefix;
    private $pdo;

    public function __construct() {}

    public function getPdo()
    {
        return $this->pdo;
    }

    public function initTables($db_prefix)
    {
        if (!$this->pdo) {
            throw new \App\Exceptions\DatabaseException('La connexion à la base de données n\'a pas été initialisée.');
        }

        $queries = array(
            'DROP TABLE IF EXISTS "'.$db_prefix.'categorie_message";',
            'DROP SEQUENCE IF EXISTS '.$db_prefix.'categorie_contact_id_seq;',
            'CREATE SEQUENCE '.$db_prefix.'categorie_contact_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;',
            'CREATE TABLE "public"."'.$db_prefix.'categorie_message" ( "id" integer DEFAULT nextval(\''.$db_prefix.'categorie_contact_id_seq\') NOT NULL, "description" character varying(255) NOT NULL, CONSTRAINT "'.$db_prefix.'categorie_contact_pkey" PRIMARY KEY ("id") ) WITH (oids = false);',
            'INSERT INTO "'.$db_prefix.'categorie_message" ("id", "description") VALUES (1, \'Question générale\'), (2, \'Remerciement\'), (3, \'Autre\');',
            'DROP TABLE IF EXISTS "'.$db_prefix.'category_movie";',
            'DROP SEQUENCE IF EXISTS '.$db_prefix.'movie_category_id_seq;',
            'CREATE SEQUENCE '.$db_prefix.'movie_category_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;',
            'CREATE TABLE "public"."'.$db_prefix.'category_movie" ( "id" integer DEFAULT nextval(\''.$db_prefix.'movie_category_id_seq\') NOT NULL, "name" character varying(100) NOT NULL, "created_at" timestamp, "updated_at" timestamp, CONSTRAINT "'.$db_prefix.'movie_category_pkey" PRIMARY KEY ("id") ) WITH (oids = false);',
            'DROP TABLE IF EXISTS "'.$db_prefix.'comment";',
            'DROP SEQUENCE IF EXISTS '.$db_prefix.'comment_id_seq;',
            'CREATE SEQUENCE '.$db_prefix.'comment_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;',
            'CREATE TABLE "public"."'.$db_prefix.'comment" ( "id" integer DEFAULT nextval(\''.$db_prefix.'comment_id_seq\') NOT NULL, "entity" character varying NOT NULL, "id_entity" integer NOT NULL, "id_user" integer NOT NULL, "content" character varying NOT NULL, "created_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL, "updated_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL, "id_status" integer NOT NULL, CONSTRAINT "'.$db_prefix.'comment_pkey" PRIMARY KEY ("id") ) WITH (oids = false);',
            'DROP TABLE IF EXISTS "'.$db_prefix.'comment_reply";',
            'DROP SEQUENCE IF EXISTS '.$db_prefix.'comment_answer_id_seq;',
            'CREATE SEQUENCE '.$db_prefix.'comment_answer_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;',
            'CREATE TABLE "public"."'.$db_prefix.'comment_reply" ( "id" integer DEFAULT nextval(\''.$db_prefix.'comment_answer_id_seq\') NOT NULL, "id_comment" integer NOT NULL, "id_user" integer NOT NULL, "content" character varying NOT NULL, "created_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL, "updated_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL, "id_status" smallint NOT NULL, CONSTRAINT "'.$db_prefix.'comment_answer_pkey" PRIMARY KEY ("id") ) WITH (oids = false);',
            'DROP TABLE IF EXISTS "'.$db_prefix.'comment_status";',
            'DROP SEQUENCE IF EXISTS '.$db_prefix.'comment_status_id_seq;',
            'CREATE SEQUENCE '.$db_prefix.'comment_status_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;',
            'CREATE TABLE "public"."'.$db_prefix.'comment_status" ( "id" integer DEFAULT nextval(\''.$db_prefix.'comment_status_id_seq\') NOT NULL, "intitule" character varying NOT NULL, CONSTRAINT "'.$db_prefix.'comment_status_pkey" PRIMARY KEY ("id") ) WITH (oids = false);',
            'INSERT INTO "'.$db_prefix.'comment_status" ("id", "intitule") VALUES (1, \'Actif\'), (2, \'Refusé\'), (3, \'Non traité\');',
            'DROP TABLE IF EXISTS "'.$db_prefix.'country";',
            'DROP SEQUENCE IF EXISTS country_id_seq1;',
            'CREATE SEQUENCE country_id_seq1 INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;',
            'CREATE TABLE "public"."'.$db_prefix.'country" ("id" integer DEFAULT nextval(\'country_id_seq1\') NOT NULL, "iso" character(2) NOT NULL, "name" character varying(80) NOT NULL, "nicename" character varying(80) NOT NULL, "iso3" character(3), "numcode" smallint, "phonecode" integer NOT NULL, CONSTRAINT "country_pkey1" PRIMARY KEY ("id")) WITH (oids = false);',
            'INSERT INTO "'.$db_prefix.'country" ("id", "iso", "name", "nicename", "iso3", "numcode", "phonecode") VALUES
            (1,	\'AF\',	\'AFGHANISTAN\',	\'Afghanistan\',	\'AFG\',	4,	93),
            (2,	\'AL\',	\'ALBANIA\',	\'Albania\',	\'ALB\',	8,	355),
            (3,	\'DZ\',	\'ALGERIA\',	\'Algeria\',	\'DZA\',	12,	213),
            (4,	\'AS\',	\'AMERICAN SAMOA\',	\'American Samoa\',	\'ASM\',	16,	1684),
            (5,	\'AD\',	\'ANDORRA\',	\'Andorra\',	\'AND\',	20,	376),
            (6,	\'AO\',	\'ANGOLA\',	\'Angola\',	\'AGO\',	24,	244),
            (7,	\'AI\',	\'ANGUILLA\',	\'Anguilla\',	\'AIA\',	660,	1264),
            (8,	\'AQ\',	\'ANTARCTICA\',	\'Antarctica\',	NULL,	NULL,	0),
            (9,	\'AG\',	\'ANTIGUA AND BARBUDA\',	\'Antigua and Barbuda\',	\'ATG\',	28,	1268),
            (10,	\'AR\',	\'ARGENTINA\',	\'Argentina\',	\'ARG\',	32,	54),
            (11,	\'AM\',	\'ARMENIA\',	\'Armenia\',	\'ARM\',	51,	374),
            (12,	\'AW\',	\'ARUBA\',	\'Aruba\',	\'ABW\',	533,	297),
            (13,	\'AU\',	\'AUSTRALIA\',	\'Australia\',	\'AUS\',	36,	61),
            (14,	\'AT\',	\'AUSTRIA\',	\'Austria\',	\'AUT\',	40,	43),
            (15,	\'AZ\',	\'AZERBAIJAN\',	\'Azerbaijan\',	\'AZE\',	31,	994),
            (16,	\'BS\',	\'BAHAMAS\',	\'Bahamas\',	\'BHS\',	44,	1242),
            (17,	\'BH\',	\'BAHRAIN\',	\'Bahrain\',	\'BHR\',	48,	973),
            (18,	\'BD\',	\'BANGLADESH\',	\'Bangladesh\',	\'BGD\',	50,	880),
            (19,	\'BB\',	\'BARBADOS\',	\'Barbados\',	\'BRB\',	52,	1246),
            (20,	\'BY\',	\'BELARUS\',	\'Belarus\',	\'BLR\',	112,	375),
            (21,	\'BE\',	\'BELGIUM\',	\'Belgium\',	\'BEL\',	56,	32),
            (22,	\'BZ\',	\'BELIZE\',	\'Belize\',	\'BLZ\',	84,	501),
            (23,	\'BJ\',	\'BENIN\',	\'Benin\',	\'BEN\',	204,	229),
            (24,	\'BM\',	\'BERMUDA\',	\'Bermuda\',	\'BMU\',	60,	1441),
            (25,	\'BT\',	\'BHUTAN\',	\'Bhutan\',	\'BTN\',	64,	975),
            (26,	\'BO\',	\'BOLIVIA\',	\'Bolivia\',	\'BOL\',	68,	591),
            (27,	\'BA\',	\'BOSNIA AND HERZEGOVINA\',	\'Bosnia and Herzegovina\',	\'BIH\',	70,	387),
            (28,	\'BW\',	\'BOTSWANA\',	\'Botswana\',	\'BWA\',	72,	267),
            (29,	\'BV\',	\'BOUVET ISLAND\',	\'Bouvet Island\',	NULL,	NULL,	0),
            (30,	\'BR\',	\'BRAZIL\',	\'Brazil\',	\'BRA\',	76,	55),
            (31,	\'IO\',	\'BRITISH INDIAN OCEAN TERRITORY\',	\'British Indian Ocean Territory\',	NULL,	NULL,	246),
            (32,	\'BN\',	\'BRUNEI DARUSSALAM\',	\'Brunei Darussalam\',	\'BRN\',	96,	673),
            (33,	\'BG\',	\'BULGARIA\',	\'Bulgaria\',	\'BGR\',	100,	359),
            (34,	\'BF\',	\'BURKINA FASO\',	\'Burkina Faso\',	\'BFA\',	854,	226),
            (35,	\'BI\',	\'BURUNDI\',	\'Burundi\',	\'BDI\',	108,	257),
            (36,	\'KH\',	\'CAMBODIA\',	\'Cambodia\',	\'KHM\',	116,	855),
            (37,	\'CM\',	\'CAMEROON\',	\'Cameroon\',	\'CMR\',	120,	237),
            (38,	\'CA\',	\'CANADA\',	\'Canada\',	\'CAN\',	124,	1),
            (39,	\'CV\',	\'CAPE VERDE\',	\'Cape Verde\',	\'CPV\',	132,	238),
            (40,	\'KY\',	\'CAYMAN ISLANDS\',	\'Cayman Islands\',	\'CYM\',	136,	1345),
            (41,	\'CF\',	\'CENTRAL AFRICAN REPUBLIC\',	\'Central African Republic\',	\'CAF\',	140,	236),
            (42,	\'TD\',	\'CHAD\',	\'Chad\',	\'TCD\',	148,	235),
            (43,	\'CL\',	\'CHILE\',	\'Chile\',	\'CHL\',	152,	56),
            (44,	\'CN\',	\'CHINA\',	\'China\',	\'CHN\',	156,	86),
            (45,	\'CX\',	\'CHRISTMAS ISLAND\',	\'Christmas Island\',	NULL,	NULL,	61),
            (46,	\'CC\',	\'COCOS (KEELING) ISLANDS\',	\'Cocos (Keeling) Islands\',	NULL,	NULL,	672),
            (47,	\'CO\',	\'COLOMBIA\',	\'Colombia\',	\'COL\',	170,	57),
            (48,	\'KM\',	\'COMOROS\',	\'Comoros\',	\'COM\',	174,	269),
            (49,	\'CG\',	\'CONGO\',	\'Congo\',	\'COG\',	178,	242),
            (50,	\'CD\',	\'CONGO, THE DEMOCRATIC REPUBLIC OF THE\',	\'Congo, the Democratic Republic of the\',	\'COD\',	180,	242),
            (51,	\'CK\',	\'COOK ISLANDS\',	\'Cook Islands\',	\'COK\',	184,	682),
            (52,	\'CR\',	\'COSTA RICA\',	\'Costa Rica\',	\'CRI\',	188,	506),
            (53,	\'CI\',	\'COTE D\'\'IVOIRE\',	\'Cote D\'\'Ivoire\',	\'CIV\',	384,	225),
            (54,	\'HR\',	\'CROATIA\',	\'Croatia\',	\'HRV\',	191,	385),
            (55,	\'CU\',	\'CUBA\',	\'Cuba\',	\'CUB\',	192,	53),
            (56,	\'CY\',	\'CYPRUS\',	\'Cyprus\',	\'CYP\',	196,	357),
            (57,	\'CZ\',	\'CZECH REPUBLIC\',	\'Czech Republic\',	\'CZE\',	203,	420),
            (58,	\'DK\',	\'DENMARK\',	\'Denmark\',	\'DNK\',	208,	45),
            (59,	\'DJ\',	\'DJIBOUTI\',	\'Djibouti\',	\'DJI\',	262,	253),
            (60,	\'DM\',	\'DOMINICA\',	\'Dominica\',	\'DMA\',	212,	1767),
            (61,	\'DO\',	\'DOMINICAN REPUBLIC\',	\'Dominican Republic\',	\'DOM\',	214,	1809),
            (62,	\'EC\',	\'ECUADOR\',	\'Ecuador\',	\'ECU\',	218,	593),
            (63,	\'EG\',	\'EGYPT\',	\'Egypt\',	\'EGY\',	818,	20),
            (64,	\'SV\',	\'EL SALVADOR\',	\'El Salvador\',	\'SLV\',	222,	503),
            (65,	\'GQ\',	\'EQUATORIAL GUINEA\',	\'Equatorial Guinea\',	\'GNQ\',	226,	240),
            (66,	\'ER\',	\'ERITREA\',	\'Eritrea\',	\'ERI\',	232,	291),
            (67,	\'EE\',	\'ESTONIA\',	\'Estonia\',	\'EST\',	233,	372),
            (68,	\'ET\',	\'ETHIOPIA\',	\'Ethiopia\',	\'ETH\',	231,	251),
            (69,	\'FK\',	\'FALKLAND ISLANDS (MALVINAS)\',	\'Falkland Islands (Malvinas)\',	\'FLK\',	238,	500),
            (70,	\'FO\',	\'FAROE ISLANDS\',	\'Faroe Islands\',	\'FRO\',	234,	298),
            (71,	\'FJ\',	\'FIJI\',	\'Fiji\',	\'FJI\',	242,	679),
            (72,	\'FI\',	\'FINLAND\',	\'Finland\',	\'FIN\',	246,	358),
            (73,	\'FR\',	\'FRANCE\',	\'France\',	\'FRA\',	250,	33),
            (74,	\'GF\',	\'FRENCH GUIANA\',	\'French Guiana\',	\'GUF\',	254,	594),
            (75,	\'PF\',	\'FRENCH POLYNESIA\',	\'French Polynesia\',	\'PYF\',	258,	689),
            (76,	\'TF\',	\'FRENCH SOUTHERN TERRITORIES\',	\'French Southern Territories\',	NULL,	NULL,	0),
            (77,	\'GA\',	\'GABON\',	\'Gabon\',	\'GAB\',	266,	241),
            (78,	\'GM\',	\'GAMBIA\',	\'Gambia\',	\'GMB\',	270,	220),
            (79,	\'GE\',	\'GEORGIA\',	\'Georgia\',	\'GEO\',	268,	995),
            (80,	\'DE\',	\'GERMANY\',	\'Germany\',	\'DEU\',	276,	49),
            (81,	\'GH\',	\'GHANA\',	\'Ghana\',	\'GHA\',	288,	233),
            (82,	\'GI\',	\'GIBRALTAR\',	\'Gibraltar\',	\'GIB\',	292,	350),
            (83,	\'GR\',	\'GREECE\',	\'Greece\',	\'GRC\',	300,	30),
            (84,	\'GL\',	\'GREENLAND\',	\'Greenland\',	\'GRL\',	304,	299),
            (85,	\'GD\',	\'GRENADA\',	\'Grenada\',	\'GRD\',	308,	1473),
            (86,	\'GP\',	\'GUADELOUPE\',	\'Guadeloupe\',	\'GLP\',	312,	590),
            (87,	\'GU\',	\'GUAM\',	\'Guam\',	\'GUM\',	316,	1671),
            (88,	\'GT\',	\'GUATEMALA\',	\'Guatemala\',	\'GTM\',	320,	502),
            (89,	\'GN\',	\'GUINEA\',	\'Guinea\',	\'GIN\',	324,	224),
            (90,	\'GW\',	\'GUINEA-BISSAU\',	\'Guinea-Bissau\',	\'GNB\',	624,	245),
            (91,	\'GY\',	\'GUYANA\',	\'Guyana\',	\'GUY\',	328,	592),
            (92,	\'HT\',	\'HAITI\',	\'Haiti\',	\'HTI\',	332,	509),
            (93,	\'HM\',	\'HEARD ISLAND AND MCDONALD ISLANDS\',	\'Heard Island and Mcdonald Islands\',	NULL,	NULL,	0),
            (94,	\'VA\',	\'HOLY SEE (VATICAN CITY STATE)\',	\'Holy See (Vatican City State)\',	\'VAT\',	336,	39),
            (95,	\'HN\',	\'HONDURAS\',	\'Honduras\',	\'HND\',	340,	504),
            (96,	\'HK\',	\'HONG KONG\',	\'Hong Kong\',	\'HKG\',	344,	852),
            (97,	\'HU\',	\'HUNGARY\',	\'Hungary\',	\'HUN\',	348,	36),
            (98,	\'IS\',	\'ICELAND\',	\'Iceland\',	\'ISL\',	352,	354),
            (99,	\'IN\',	\'INDIA\',	\'India\',	\'IND\',	356,	91),
            (100,	\'ID\',	\'INDONESIA\',	\'Indonesia\',	\'IDN\',	360,	62),
            (101,	\'IR\',	\'IRAN, ISLAMIC REPUBLIC OF\',	\'Iran, Islamic Republic of\',	\'IRN\',	364,	98),
            (102,	\'IQ\',	\'IRAQ\',	\'Iraq\',	\'IRQ\',	368,	964),
            (103,	\'IE\',	\'IRELAND\',	\'Ireland\',	\'IRL\',	372,	353),
            (104,	\'IL\',	\'ISRAEL\',	\'Israel\',	\'ISR\',	376,	972),
            (105,	\'IT\',	\'ITALY\',	\'Italy\',	\'ITA\',	380,	39),
            (106,	\'JM\',	\'JAMAICA\',	\'Jamaica\',	\'JAM\',	388,	1876),
            (107,	\'JP\',	\'JAPAN\',	\'Japan\',	\'JPN\',	392,	81),
            (108,	\'JO\',	\'JORDAN\',	\'Jordan\',	\'JOR\',	400,	962),
            (109,	\'KZ\',	\'KAZAKHSTAN\',	\'Kazakhstan\',	\'KAZ\',	398,	7),
            (110,	\'KE\',	\'KENYA\',	\'Kenya\',	\'KEN\',	404,	254),
            (111,	\'KI\',	\'KIRIBATI\',	\'Kiribati\',	\'KIR\',	296,	686),
            (112,	\'KP\',	\'KOREA, DEMOCRATIC PEOPLE\'\'S REPUBLIC OF\',	\'Korea, Democratic People\'\'s Republic of\',	\'PRK\',	408,	850),
            (113,	\'KR\',	\'KOREA, REPUBLIC OF\',	\'Korea, Republic of\',	\'KOR\',	410,	82),
            (114,	\'KW\',	\'KUWAIT\',	\'Kuwait\',	\'KWT\',	414,	965),
            (115,	\'KG\',	\'KYRGYZSTAN\',	\'Kyrgyzstan\',	\'KGZ\',	417,	996),
            (116,	\'LA\',	\'LAO PEOPLE\'\'S DEMOCRATIC REPUBLIC\',	\'Lao People\'\'s Democratic Republic\',	\'LAO\',	418,	856),
            (117,	\'LV\',	\'LATVIA\',	\'Latvia\',	\'LVA\',	428,	371),
            (118,	\'LB\',	\'LEBANON\',	\'Lebanon\',	\'LBN\',	422,	961),
            (119,	\'LS\',	\'LESOTHO\',	\'Lesotho\',	\'LSO\',	426,	266),
            (120,	\'LR\',	\'LIBERIA\',	\'Liberia\',	\'LBR\',	430,	231),
            (121,	\'LY\',	\'LIBYAN ARAB JAMAHIRIYA\',	\'Libyan Arab Jamahiriya\',	\'LBY\',	434,	218),
            (122,	\'LI\',	\'LIECHTENSTEIN\',	\'Liechtenstein\',	\'LIE\',	438,	423),
            (123,	\'LT\',	\'LITHUANIA\',	\'Lithuania\',	\'LTU\',	440,	370),
            (124,	\'LU\',	\'LUXEMBOURG\',	\'Luxembourg\',	\'LUX\',	442,	352),
            (125,	\'MO\',	\'MACAO\',	\'Macao\',	\'MAC\',	446,	853),
            (126,	\'MK\',	\'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF\',	\'Macedonia, the Former Yugoslav Republic of\',	\'MKD\',	807,	389),
            (127,	\'MG\',	\'MADAGASCAR\',	\'Madagascar\',	\'MDG\',	450,	261),
            (128,	\'MW\',	\'MALAWI\',	\'Malawi\',	\'MWI\',	454,	265),
            (129,	\'MY\',	\'MALAYSIA\',	\'Malaysia\',	\'MYS\',	458,	60),
            (130,	\'MV\',	\'MALDIVES\',	\'Maldives\',	\'MDV\',	462,	960),
            (131,	\'ML\',	\'MALI\',	\'Mali\',	\'MLI\',	466,	223),
            (132,	\'MT\',	\'MALTA\',	\'Malta\',	\'MLT\',	470,	356),
            (133,	\'MH\',	\'MARSHALL ISLANDS\',	\'Marshall Islands\',	\'MHL\',	584,	692),
            (134,	\'MQ\',	\'MARTINIQUE\',	\'Martinique\',	\'MTQ\',	474,	596),
            (135,	\'MR\',	\'MAURITANIA\',	\'Mauritania\',	\'MRT\',	478,	222),
            (136,	\'MU\',	\'MAURITIUS\',	\'Mauritius\',	\'MUS\',	480,	230),
            (137,	\'YT\',	\'MAYOTTE\',	\'Mayotte\',	NULL,	NULL,	269),
            (138,	\'MX\',	\'MEXICO\',	\'Mexico\',	\'MEX\',	484,	52),
            (139,	\'FM\',	\'MICRONESIA, FEDERATED STATES OF\',	\'Micronesia, Federated States of\',	\'FSM\',	583,	691),
            (140,	\'MD\',	\'MOLDOVA, REPUBLIC OF\',	\'Moldova, Republic of\',	\'MDA\',	498,	373),
            (141,	\'MC\',	\'MONACO\',	\'Monaco\',	\'MCO\',	492,	377),
            (142,	\'MN\',	\'MONGOLIA\',	\'Mongolia\',	\'MNG\',	496,	976),
            (143,	\'MS\',	\'MONTSERRAT\',	\'Montserrat\',	\'MSR\',	500,	1664),
            (144,	\'MA\',	\'MOROCCO\',	\'Morocco\',	\'MAR\',	504,	212),
            (145,	\'MZ\',	\'MOZAMBIQUE\',	\'Mozambique\',	\'MOZ\',	508,	258),
            (146,	\'MM\',	\'MYANMAR\',	\'Myanmar\',	\'MMR\',	104,	95),
            (147,	\'NA\',	\'NAMIBIA\',	\'Namibia\',	\'NAM\',	516,	264),
            (148,	\'NR\',	\'NAURU\',	\'Nauru\',	\'NRU\',	520,	674),
            (149,	\'NP\',	\'NEPAL\',	\'Nepal\',	\'NPL\',	524,	977),
            (150,	\'NL\',	\'NETHERLANDS\',	\'Netherlands\',	\'NLD\',	528,	31),
            (151,	\'AN\',	\'NETHERLANDS ANTILLES\',	\'Netherlands Antilles\',	\'ANT\',	530,	599),
            (152,	\'NC\',	\'NEW CALEDONIA\',	\'New Caledonia\',	\'NCL\',	540,	687),
            (153,	\'NZ\',	\'NEW ZEALAND\',	\'New Zealand\',	\'NZL\',	554,	64),
            (154,	\'NI\',	\'NICARAGUA\',	\'Nicaragua\',	\'NIC\',	558,	505),
            (155,	\'NE\',	\'NIGER\',	\'Niger\',	\'NER\',	562,	227),
            (156,	\'NG\',	\'NIGERIA\',	\'Nigeria\',	\'NGA\',	566,	234),
            (157,	\'NU\',	\'NIUE\',	\'Niue\',	\'NIU\',	570,	683),
            (158,	\'NF\',	\'NORFOLK ISLAND\',	\'Norfolk Island\',	\'NFK\',	574,	672),
            (159,	\'MP\',	\'NORTHERN MARIANA ISLANDS\',	\'Northern Mariana Islands\',	\'MNP\',	580,	1670),
            (160,	\'NO\',	\'NORWAY\',	\'Norway\',	\'NOR\',	578,	47),
            (161,	\'OM\',	\'OMAN\',	\'Oman\',	\'OMN\',	512,	968),
            (162,	\'PK\',	\'PAKISTAN\',	\'Pakistan\',	\'PAK\',	586,	92),
            (163,	\'PW\',	\'PALAU\',	\'Palau\',	\'PLW\',	585,	680),
            (164,	\'PS\',	\'PALESTINIAN TERRITORY, OCCUPIED\',	\'Palestinian Territory, Occupied\',	NULL,	NULL,	970),
            (165,	\'PA\',	\'PANAMA\',	\'Panama\',	\'PAN\',	591,	507),
            (166,	\'PG\',	\'PAPUA NEW GUINEA\',	\'Papua New Guinea\',	\'PNG\',	598,	675),
            (167,	\'PY\',	\'PARAGUAY\',	\'Paraguay\',	\'PRY\',	600,	595),
            (168,	\'PE\',	\'PERU\',	\'Peru\',	\'PER\',	604,	51),
            (169,	\'PH\',	\'PHILIPPINES\',	\'Philippines\',	\'PHL\',	608,	63),
            (170,	\'PN\',	\'PITCAIRN\',	\'Pitcairn\',	\'PCN\',	612,	0),
            (171,	\'PL\',	\'POLAND\',	\'Poland\',	\'POL\',	616,	48),
            (172,	\'PT\',	\'PORTUGAL\',	\'Portugal\',	\'PRT\',	620,	351),
            (173,	\'PR\',	\'PUERTO RICO\',	\'Puerto Rico\',	\'PRI\',	630,	1787),
            (174,	\'QA\',	\'QATAR\',	\'Qatar\',	\'QAT\',	634,	974),
            (175,	\'RE\',	\'REUNION\',	\'Reunion\',	\'REU\',	638,	262),
            (176,	\'RO\',	\'ROMANIA\',	\'Romania\',	\'ROM\',	642,	40),
            (177,	\'RU\',	\'RUSSIAN FEDERATION\',	\'Russian Federation\',	\'RUS\',	643,	70),
            (178,	\'RW\',	\'RWANDA\',	\'Rwanda\',	\'RWA\',	646,	250),
            (179,	\'SH\',	\'SAINT HELENA\',	\'Saint Helena\',	\'SHN\',	654,	290),
            (180,	\'KN\',	\'SAINT KITTS AND NEVIS\',	\'Saint Kitts and Nevis\',	\'KNA\',	659,	1869),
            (181,	\'LC\',	\'SAINT LUCIA\',	\'Saint Lucia\',	\'LCA\',	662,	1758),
            (182,	\'PM\',	\'SAINT PIERRE AND MIQUELON\',	\'Saint Pierre and Miquelon\',	\'SPM\',	666,	508),
            (183,	\'VC\',	\'SAINT VINCENT AND THE GRENADINES\',	\'Saint Vincent and the Grenadines\',	\'VCT\',	670,	1784),
            (184,	\'WS\',	\'SAMOA\',	\'Samoa\',	\'WSM\',	882,	684),
            (185,	\'SM\',	\'SAN MARINO\',	\'San Marino\',	\'SMR\',	674,	378),
            (186,	\'ST\',	\'SAO TOME AND PRINCIPE\',	\'Sao Tome and Principe\',	\'STP\',	678,	239),
            (187,	\'SA\',	\'SAUDI ARABIA\',	\'Saudi Arabia\',	\'SAU\',	682,	966),
            (188,	\'SN\',	\'SENEGAL\',	\'Senegal\',	\'SEN\',	686,	221),
            (189,	\'CS\',	\'SERBIA AND MONTENEGRO\',	\'Serbia and Montenegro\',	NULL,	NULL,	381),
            (190,	\'SC\',	\'SEYCHELLES\',	\'Seychelles\',	\'SYC\',	690,	248),
            (191,	\'SL\',	\'SIERRA LEONE\',	\'Sierra Leone\',	\'SLE\',	694,	232),
            (192,	\'SG\',	\'SINGAPORE\',	\'Singapore\',	\'SGP\',	702,	65),
            (193,	\'SK\',	\'SLOVAKIA\',	\'Slovakia\',	\'SVK\',	703,	421),
            (194,	\'SI\',	\'SLOVENIA\',	\'Slovenia\',	\'SVN\',	705,	386),
            (195,	\'SB\',	\'SOLOMON ISLANDS\',	\'Solomon Islands\',	\'SLB\',	90,	677),
            (196,	\'SO\',	\'SOMALIA\',	\'Somalia\',	\'SOM\',	706,	252),
            (197,	\'ZA\',	\'SOUTH AFRICA\',	\'South Africa\',	\'ZAF\',	710,	27),
            (198,	\'GS\',	\'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS\',	\'South Georgia and the South Sandwich Islands\',	NULL,	NULL,	0),
            (199,	\'ES\',	\'SPAIN\',	\'Spain\',	\'ESP\',	724,	34),
            (200,	\'LK\',	\'SRI LANKA\',	\'Sri Lanka\',	\'LKA\',	144,	94),
            (201,	\'SD\',	\'SUDAN\',	\'Sudan\',	\'SDN\',	736,	249),
            (202,	\'SR\',	\'SURINAME\',	\'Suriname\',	\'SUR\',	740,	597),
            (203,	\'SJ\',	\'SVALBARD AND JAN MAYEN\',	\'Svalbard and Jan Mayen\',	\'SJM\',	744,	47),
            (204,	\'SZ\',	\'SWAZILAND\',	\'Swaziland\',	\'SWZ\',	748,	268),
            (205,	\'SE\',	\'SWEDEN\',	\'Sweden\',	\'SWE\',	752,	46),
            (206,	\'CH\',	\'SWITZERLAND\',	\'Switzerland\',	\'CHE\',	756,	41),
            (207,	\'SY\',	\'SYRIAN ARAB REPUBLIC\',	\'Syrian Arab Republic\',	\'SYR\',	760,	963),
            (208,	\'TW\',	\'TAIWAN, PROVINCE OF CHINA\',	\'Taiwan, Province of China\',	\'TWN\',	158,	886),
            (209,	\'TJ\',	\'TAJIKISTAN\',	\'Tajikistan\',	\'TJK\',	762,	992),
            (210,	\'TZ\',	\'TANZANIA, UNITED REPUBLIC OF\',	\'Tanzania, United Republic of\',	\'TZA\',	834,	255),
            (211,	\'TH\',	\'THAILAND\',	\'Thailand\',	\'THA\',	764,	66),
            (212,	\'TL\',	\'TIMOR-LESTE\',	\'Timor-Leste\',	NULL,	NULL,	670),
            (213,	\'TG\',	\'TOGO\',	\'Togo\',	\'TGO\',	768,	228),
            (214,	\'TK\',	\'TOKELAU\',	\'Tokelau\',	\'TKL\',	772,	690),
            (215,	\'TO\',	\'TONGA\',	\'Tonga\',	\'TON\',	776,	676),
            (216,	\'TT\',	\'TRINIDAD AND TOBAGO\',	\'Trinidad and Tobago\',	\'TTO\',	780,	1868),
            (217,	\'TN\',	\'TUNISIA\',	\'Tunisia\',	\'TUN\',	788,	216),
            (218,	\'TR\',	\'TURKEY\',	\'Turkey\',	\'TUR\',	792,	90),
            (219,	\'TM\',	\'TURKMENISTAN\',	\'Turkmenistan\',	\'TKM\',	795,	7370),
            (220,	\'TC\',	\'TURKS AND CAICOS ISLANDS\',	\'Turks and Caicos Islands\',	\'TCA\',	796,	1649),
            (221,	\'TV\',	\'TUVALU\',	\'Tuvalu\',	\'TUV\',	798,	688),
            (222,	\'UG\',	\'UGANDA\',	\'Uganda\',	\'UGA\',	800,	256),
            (223,	\'UA\',	\'UKRAINE\',	\'Ukraine\',	\'UKR\',	804,	380),
            (224,	\'AE\',	\'UNITED ARAB EMIRATES\',	\'United Arab Emirates\',	\'ARE\',	784,	971),
            (225,	\'GB\',	\'UNITED KINGDOM\',	\'United Kingdom\',	\'GBR\',	826,	44),
            (226,	\'US\',	\'UNITED STATES\',	\'United States\',	\'USA\',	840,	1),
            (227,	\'UM\',	\'UNITED STATES MINOR OUTLYING ISLANDS\',	\'United States Minor Outlying Islands\',	NULL,	NULL,	1),
            (228,	\'UY\',	\'URUGUAY\',	\'Uruguay\',	\'URY\',	858,	598),
            (229,	\'UZ\',	\'UZBEKISTAN\',	\'Uzbekistan\',	\'UZB\',	860,	998),
            (230,	\'VU\',	\'VANUATU\',	\'Vanuatu\',	\'VUT\',	548,	678),
            (231,	\'VE\',	\'VENEZUELA\',	\'Venezuela\',	\'VEN\',	862,	58),
            (232,	\'VN\',	\'VIET NAM\',	\'Viet Nam\',	\'VNM\',	704,	84),
            (233,	\'VG\',	\'VIRGIN ISLANDS, BRITISH\',	\'Virgin Islands, British\',	\'VGB\',	92,	1284),
            (234,	\'VI\',	\'VIRGIN ISLANDS, U.S.\',	\'Virgin Islands, U.s.\',	\'VIR\',	850,	1340),
            (235,	\'WF\',	\'WALLIS AND FUTUNA\',	\'Wallis and Futuna\',	\'WLF\',	876,	681),
            (236,	\'EH\',	\'WESTERN SAHARA\',	\'Western Sahara\',	\'ESH\',	732,	212),
            (237,	\'YE\',	\'YEMEN\',	\'Yemen\',	\'YEM\',	887,	967),
            (238,	\'ZM\',	\'ZAMBIA\',	\'Zambia\',	\'ZMB\',	894,	260),
            (239,	\'ZW\',	\'ZIMBABWE\',	\'Zimbabwe\',	\'ZWE\',	716,	263);',
            'DROP TABLE IF EXISTS "'.$db_prefix.'email_activation_token";',
            'DROP SEQUENCE IF EXISTS email_activation_tokens_id_seq;',
            'CREATE SEQUENCE email_activation_tokens_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;',
            'CREATE TABLE "public"."'.$db_prefix.'email_activation_token" (
                "id" integer DEFAULT nextval(\'email_activation_tokens_id_seq\') NOT NULL,
                "id_user" integer NOT NULL,
                "token" character varying(255) NOT NULL,
                "verified_at" timestamp,
                "created_at" timestamp DEFAULT CURRENT_TIMESTAMP,
                "updated_at" timestamp DEFAULT CURRENT_TIMESTAMP,
                "sent_at" timestamp,
                "verified_by_admin" smallint DEFAULT \'0\' NOT NULL,
                CONSTRAINT "email_activation_tokens_pkey" PRIMARY KEY ("id")
            ) WITH (oids = false);',
            'DROP TABLE IF EXISTS "'.$db_prefix.'forgot_password";',
            'DROP SEQUENCE IF EXISTS forgot_password_request_id_seq;',
            'CREATE SEQUENCE forgot_password_request_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;',
            'CREATE TABLE "public"."'.$db_prefix.'forgot_password" (
                "id" integer DEFAULT nextval(\'forgot_password_request_id_seq\') NOT NULL,
                "id_user" integer NOT NULL,
                "token" character varying(256) NOT NULL,
                "created_at" timestamp NOT NULL,
                "send_at" timestamp,
                "completed_at" timestamp,
                CONSTRAINT "forgot_password_request_pkey" PRIMARY KEY ("id")
            ) WITH (oids = false);',
            'DROP TABLE IF EXISTS "'.$db_prefix.'job";',
            'DROP SEQUENCE IF EXISTS '.$db_prefix.'job_id_seq;',
            'CREATE SEQUENCE '.$db_prefix.'job_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;',
            'CREATE TABLE "public"."'.$db_prefix.'job" (
                "id" integer DEFAULT nextval(\''.$db_prefix.'job_id_seq\') NOT NULL,
                "name" character varying(100) NOT NULL,
                "created_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
                CONSTRAINT "'.$db_prefix.'job_pkey" PRIMARY KEY ("id")
            ) WITH (oids = false);',
            'INSERT INTO "'.$db_prefix.'job" ("id", "name", "created_at") VALUES
            (1,	\'Réalisateur\',	\'2023-07-21 11:45:15.471921\'),
            (2,	\'Producteur\',	\'2023-07-21 11:45:22.703594\'),
            (3,	\'Acteur\',	\'2023-07-21 11:45:25.979566\'),
            (4,	\'Cadreur\',	\'2023-07-21 11:45:29.168793\'),
            (5,	\'Ingénieur son\',	\'2023-07-21 11:45:32.721528\');',
            'DROP TABLE IF EXISTS "'.$db_prefix.'media";',
            'DROP SEQUENCE IF EXISTS '.$db_prefix.'media_id_seq;',
            'CREATE SEQUENCE '.$db_prefix.'media_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;',
            'CREATE TABLE "public"."'.$db_prefix.'media" (
                "id" integer DEFAULT nextval(\''.$db_prefix.'media_id_seq\') NOT NULL,
                "name" character varying(255) NOT NULL,
                "alt" character varying(255) NOT NULL,
                "slug" character varying(500) NOT NULL,
                "type" character varying(19) NOT NULL,
                "created_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
                "updated_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
                CONSTRAINT "'.$db_prefix.'media_pkey" PRIMARY KEY ("id")
            ) WITH (oids = false);',
            'DROP TABLE IF EXISTS "'.$db_prefix.'memento";',
            'DROP SEQUENCE IF EXISTS '.$db_prefix.'memento_id_seq;',
            'CREATE SEQUENCE '.$db_prefix.'memento_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;',
            'CREATE TABLE "public"."'.$db_prefix.'memento" (
                "id" integer DEFAULT nextval(\''.$db_prefix.'memento_id_seq\') NOT NULL,
                "title" character varying(255) NOT NULL,
                "slug" character varying(255) NOT NULL,
                "description" character varying(255) NOT NULL,
                "content" character varying(100000) NOT NULL,
                "created_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
                "id_page" integer NOT NULL,
                CONSTRAINT "'.$db_prefix.'memento_pkey" PRIMARY KEY ("id")
            ) WITH (oids = false);',
            'DROP TABLE IF EXISTS "'.$db_prefix.'menu";',
            'DROP SEQUENCE IF EXISTS '.$db_prefix.'menu_id_seq;',
            'CREATE SEQUENCE '.$db_prefix.'menu_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;',
            'CREATE TABLE "public"."'.$db_prefix.'menu" (
                "id" integer DEFAULT nextval(\''.$db_prefix.'menu_id_seq\') NOT NULL,
                "title" character varying NOT NULL,
                "slug" character varying NOT NULL,
                "orders" integer NOT NULL,
                "zone" integer NOT NULL,
                "id_parent" character varying,
                "status" integer NOT NULL,
                "created_at" timestamp DEFAULT CURRENT_TIMESTAMP,
                "updated_at" timestamp DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT "'.$db_prefix.'menu_pkey" PRIMARY KEY ("id")
            ) WITH (oids = false);',
            'DROP TABLE IF EXISTS "'.$db_prefix.'message";',
            'DROP SEQUENCE IF EXISTS '.$db_prefix.'contact_id_seq;',
            'CREATE SEQUENCE '.$db_prefix.'contact_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;',
            'CREATE TABLE "public"."'.$db_prefix.'message" (
                "id" integer DEFAULT nextval(\''.$db_prefix.'contact_id_seq\') NOT NULL,
                "object" character varying(255) NOT NULL,
                "message" character varying(255) NOT NULL,
                "firstname" character varying(255) NOT NULL,
                "lastname" character varying(255) NOT NULL,
                "email" character varying(255) NOT NULL,
                "created_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
                "update_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
                "id_categorie_message" integer NOT NULL,
                CONSTRAINT "'.$db_prefix.'contact_pkey" PRIMARY KEY ("id")
            ) WITH (oids = false);',
            'DROP TABLE IF EXISTS "'.$db_prefix.'movie";',
            'DROP SEQUENCE IF EXISTS '.$db_prefix.'movie_id_seq;',
            'CREATE SEQUENCE '.$db_prefix.'movie_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;',
            'CREATE TABLE "public"."'.$db_prefix.'movie" (
                "id" integer DEFAULT nextval(\''.$db_prefix.'movie_id_seq\') NOT NULL,
                "title" character varying(200) NOT NULL,
                "description" character varying(2000) NOT NULL,
                "release_date" date NOT NULL,
                "duration" integer NOT NULL,
                "created_at" timestamp NOT NULL,
                "updated_at" timestamp NOT NULL,
                "id_media" integer NOT NULL,
                CONSTRAINT "'.$db_prefix.'movie_pkey" PRIMARY KEY ("id")
            ) WITH (oids = false);',
            'DROP TABLE IF EXISTS "'.$db_prefix.'movie_category_movie";',
            'DROP SEQUENCE IF EXISTS '.$db_prefix.'movie_category_movie_id_seq;',
            'CREATE SEQUENCE '.$db_prefix.'movie_category_movie_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;',
            'CREATE TABLE "public"."'.$db_prefix.'movie_category_movie" (
                "id" integer DEFAULT nextval(\''.$db_prefix.'movie_category_movie_id_seq\') NOT NULL,
                "id_movie" integer NOT NULL,
                "id_category_movie" integer NOT NULL,
                CONSTRAINT "'.$db_prefix.'movie_category_movie_pkey" PRIMARY KEY ("id")
            ) WITH (oids = false);',
            'DROP TABLE IF EXISTS "'.$db_prefix.'page";',
            'DROP SEQUENCE IF EXISTS page_id_seq;',
            'CREATE SEQUENCE page_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;',
            'CREATE TABLE "public"."'.$db_prefix.'page" (
                "id" integer DEFAULT nextval(\'page_id_seq\') NOT NULL,
                "title" character varying(255) NOT NULL,
                "slug" character varying(255) NOT NULL,
                "description" character varying(255) NOT NULL,
                "content" character varying(100000) NOT NULL,
                "created_at" timestamp NOT NULL,
                "updated_at" timestamp NOT NULL,
                "is_home" boolean DEFAULT false NOT NULL,
                CONSTRAINT "page_pkey" PRIMARY KEY ("id")
            ) WITH (oids = false);',
            'INSERT INTO "'.$db_prefix.'page" ("id", "title", "slug", "description", "content", "created_at", "updated_at", "is_home") VALUES
            (1,	\'Accueil\',	\'/\',	\'Accueil de BlueBird\',	\'Bienvenue sur BlueBird !\',	\'2023-09-20 12:19:07.671117\',	\'2023-09-20 12:19:07.671117\',	\'t\');',
            'DROP TABLE IF EXISTS "'.$db_prefix.'productor";',
            'DROP SEQUENCE IF EXISTS '.$db_prefix.'studio_id_seq;',
            'CREATE SEQUENCE '.$db_prefix.'studio_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;',
            'CREATE TABLE "public"."'.$db_prefix.'productor" (
                "id" integer DEFAULT nextval(\''.$db_prefix.'studio_id_seq\') NOT NULL,
                "name" character varying(200) NOT NULL,
                "description" character varying(2000) NOT NULL,
                "id_country" integer,
                CONSTRAINT "'.$db_prefix.'productor_pkey" PRIMARY KEY ("id")
            ) WITH (oids = false);',
            'DROP TABLE IF EXISTS "'.$db_prefix.'review";',
            'DROP SEQUENCE IF EXISTS '.$db_prefix.'review_id_seq;',
            'CREATE SEQUENCE '.$db_prefix.'review_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;',
            'CREATE TABLE "public"."'.$db_prefix.'review" (
                "id" integer DEFAULT nextval(\''.$db_prefix.'review_id_seq\') NOT NULL,
                "rate" integer NOT NULL,
                "comment" text,
                "id_movie" integer NOT NULL,
                "id_user" integer NOT NULL,
                "created_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
                CONSTRAINT "'.$db_prefix.'review_pkey" PRIMARY KEY ("id")
            ) WITH (oids = false);',
            'DROP TABLE IF EXISTS "'.$db_prefix.'role";',
            'DROP SEQUENCE IF EXISTS '.$db_prefix.'role_id_seq;',
            'CREATE SEQUENCE '.$db_prefix.'role_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;',
            'CREATE TABLE "public"."'.$db_prefix.'role" (
                "id" integer DEFAULT nextval(\''.$db_prefix.'role_id_seq\') NOT NULL,
                "name" character varying(20) NOT NULL,
                CONSTRAINT "'.$db_prefix.'role_pkey" PRIMARY KEY ("id")
            ) WITH (oids = false);',
            'INSERT INTO "'.$db_prefix.'role" ("id", "name") VALUES
            (1,	\'admin\'),
            (2,	\'editor\'),
            (3,	\'reviewer\'),
            (4,	\'user\'),
            (5,	\'new\');',
            'DROP TABLE IF EXISTS "'.$db_prefix.'staff";',
            'DROP SEQUENCE IF EXISTS '.$db_prefix.'staff_id_seq;',
            'CREATE SEQUENCE '.$db_prefix.'staff_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;',
            'CREATE TABLE "public"."'.$db_prefix.'staff" (
                "id" integer DEFAULT nextval(\''.$db_prefix.'staff_id_seq\') NOT NULL,
                "firstname" character varying(50) NOT NULL,
                "lastname" character varying(50) NOT NULL,
                "birthdate" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
                "birthplace" character varying NOT NULL,
                "nationality" character varying NOT NULL,
                "biography" text NOT NULL,
                "created_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
                CONSTRAINT "'.$db_prefix.'staff_pkey" PRIMARY KEY ("id")
            ) WITH (oids = false);',
            'DROP TABLE IF EXISTS "'.$db_prefix.'staff_job";',
            'DROP SEQUENCE IF EXISTS '.$db_prefix.'staff_job_id_seq;',
            'CREATE SEQUENCE '.$db_prefix.'staff_job_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;',
            'CREATE TABLE "public"."'.$db_prefix.'staff_job" (
                "id" integer DEFAULT nextval(\''.$db_prefix.'staff_job_id_seq\') NOT NULL,
                "id_staff" integer NOT NULL,
                "id_job" integer NOT NULL,
                CONSTRAINT "'.$db_prefix.'staff_job_pkey" PRIMARY KEY ("id")
            ) WITH (oids = false);',
            'DROP TABLE IF EXISTS "'.$db_prefix.'user";',
            'DROP SEQUENCE IF EXISTS '.$db_prefix.'user_id_seq;',
            'CREATE SEQUENCE '.$db_prefix.'user_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;',
            'CREATE TABLE "public"."'.$db_prefix.'user" (
                "id" integer DEFAULT nextval(\''.$db_prefix.'user_id_seq\') NOT NULL,
                "firstname" character varying(60) NOT NULL,
                "lastname" character varying(120) NOT NULL,
                "email" character varying(255) NOT NULL,
                "password" character varying(255) NOT NULL,
                "status" integer NOT NULL,
                "created_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
                "updated_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
                CONSTRAINT "'.$db_prefix.'user_pkey" PRIMARY KEY ("id"),
                CONSTRAINT "unique_email" UNIQUE ("email")
            ) WITH (oids = false);',
            'DROP TABLE IF EXISTS "'.$db_prefix.'user_address";',
            'DROP SEQUENCE IF EXISTS '.$db_prefix.'user_address_id_seq;',
            'CREATE SEQUENCE '.$db_prefix.'user_address_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;',
            'CREATE TABLE "public"."'.$db_prefix.'user_address" (
                "id" integer DEFAULT nextval(\''.$db_prefix.'user_address_id_seq\') NOT NULL,
                "number" integer NOT NULL,
                "type" character varying NOT NULL,
                "street" character varying NOT NULL,
                "zip_code" integer NOT NULL,
                "id_country" integer NOT NULL,
                "id_user" integer NOT NULL,
                CONSTRAINT "'.$db_prefix.'user_address_pkey" PRIMARY KEY ("id")
            ) WITH (oids = false);',
            'DROP TABLE IF EXISTS "'.$db_prefix.'user_role";',
            'DROP SEQUENCE IF EXISTS '.$db_prefix.'user_role_id_seq;',
            'CREATE SEQUENCE '.$db_prefix.'user_role_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;',
            'CREATE TABLE "public"."'.$db_prefix.'user_role" (
                "id" integer DEFAULT nextval(\''.$db_prefix.'user_role_id_seq\') NOT NULL,
                "id_user" integer NOT NULL,
                "id_role" integer NOT NULL,
                CONSTRAINT "'.$db_prefix.'user_role_pkey" PRIMARY KEY ("id")
            ) WITH (oids = false);',
            'DROP TABLE IF EXISTS "cnzj284_post";',
            'DROP SEQUENCE IF EXISTS '.$db_prefix.'post_id_seq;',
            'CREATE SEQUENCE '.$db_prefix.'post_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;',
            'CREATE TABLE "public"."'.$db_prefix.'post" (
                "id" integer DEFAULT nextval(\''.$db_prefix.'post_id_seq\') NOT NULL,
                "title" character varying(255) NOT NULL,
                "content" text,
                "created_at" timestamp DEFAULT CURRENT_TIMESTAMP,
                "slug" character varying,
                CONSTRAINT "'.$db_prefix.'post_pkey" PRIMARY KEY ("id")
            ) WITH (oids = false);',
            'ALTER TABLE ONLY "public"."'.$db_prefix.'comment" ADD CONSTRAINT "'.$db_prefix.'comment_id_status_fkey" FOREIGN KEY (id_status) REFERENCES '.$db_prefix.'comment_status(id) NOT DEFERRABLE;',
            'ALTER TABLE ONLY "public"."'.$db_prefix.'comment_reply" ADD CONSTRAINT "'.$db_prefix.'comment_answer_id_comment_fkey" FOREIGN KEY (id_comment) REFERENCES '.$db_prefix.'comment(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;',
            'ALTER TABLE ONLY "public"."'.$db_prefix.'comment_reply" ADD CONSTRAINT "'.$db_prefix.'comment_answer_id_user_fkey" FOREIGN KEY (id_user) REFERENCES '.$db_prefix.'user(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;',
            'ALTER TABLE ONLY "public"."'.$db_prefix.'comment_reply" ADD CONSTRAINT "'.$db_prefix.'comment_reply_id_status_fkey" FOREIGN KEY (id_status) REFERENCES '.$db_prefix.'comment_status(id) NOT DEFERRABLE;',
            'ALTER TABLE ONLY "public"."'.$db_prefix.'message" ADD CONSTRAINT "'.$db_prefix.'message_id_categorie_message_fkey" FOREIGN KEY (id_categorie_message) REFERENCES '.$db_prefix.'categorie_message(id) ON UPDATE SET NULL ON DELETE SET NULL NOT DEFERRABLE;',
            'ALTER TABLE ONLY "public"."'.$db_prefix.'movie_category_movie" ADD CONSTRAINT "'.$db_prefix.'movie_category_movie_id_category_movie_fkey" FOREIGN KEY (id_category_movie) REFERENCES '.$db_prefix.'category_movie(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;',
            'ALTER TABLE ONLY "public"."'.$db_prefix.'movie_category_movie" ADD CONSTRAINT "'.$db_prefix.'movie_category_movie_id_movie_fkey" FOREIGN KEY (id_movie) REFERENCES '.$db_prefix.'movie(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;',
            'ALTER TABLE ONLY "public"."'.$db_prefix.'productor" ADD CONSTRAINT "'.$db_prefix.'productor_id_country_fkey" FOREIGN KEY (id_country) REFERENCES '.$db_prefix.'country(id) ON UPDATE SET NULL ON DELETE SET NULL NOT DEFERRABLE;',
            'ALTER TABLE ONLY "public"."'.$db_prefix.'review" ADD CONSTRAINT "'.$db_prefix.'review_id_movie_fkey" FOREIGN KEY (id_movie) REFERENCES '.$db_prefix.'movie(id) NOT DEFERRABLE;',
            'ALTER TABLE ONLY "public"."'.$db_prefix.'review" ADD CONSTRAINT "'.$db_prefix.'review_id_user_fkey" FOREIGN KEY (id_user) REFERENCES '.$db_prefix.'user(id) NOT DEFERRABLE;',
            'ALTER TABLE ONLY "public"."'.$db_prefix.'staff_job" ADD CONSTRAINT "'.$db_prefix.'staff_job_id_job_fkey" FOREIGN KEY (id_job) REFERENCES '.$db_prefix.'job(id) ON DELETE CASCADE NOT DEFERRABLE;',
            'ALTER TABLE ONLY "public"."'.$db_prefix.'staff_job" ADD CONSTRAINT "'.$db_prefix.'staff_job_id_staff_fkey" FOREIGN KEY (id_staff) REFERENCES '.$db_prefix.'staff(id) ON DELETE CASCADE NOT DEFERRABLE;',
            'ALTER TABLE ONLY "public"."'.$db_prefix.'user_address" ADD CONSTRAINT "'.$db_prefix.'user_address_id_country_fkey" FOREIGN KEY (id_country) REFERENCES '.$db_prefix.'country(id) ON UPDATE SET NULL ON DELETE SET NULL NOT DEFERRABLE;',
            'ALTER TABLE ONLY "public"."'.$db_prefix.'user_role" ADD CONSTRAINT "'.$db_prefix.'user_role_id_role_fkey" FOREIGN KEY (id_role) REFERENCES '.$db_prefix.'role(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;',
        );

        foreach ($queries as $query) {
            try {
                $stmt = $this->pdo->prepare($query);
                $stmt->execute();
            } catch (PDOException $e) {
                throw new \App\Exceptions\DatabaseException((string)$e->getMessage(), (int)$e->getCode(), $e);
            }
        }

        return true;
    }

    public function initPdo()
    {
        $dsn = 'pgsql:host='.$this->dbHost.';dbname=' . $this->dbName . ';port='.$this->dbPort;

        try {
            $pdo = new \PDO(
                $dsn,
                $this->dbUser,
                $this->dbPassword
            );
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            return false;
        }
        $this->pdo = $pdo;
        return true;
    }

    public function getDbName(): string
    {
        return $this->dbName;
    }

    public function setDbName(string $dbName): void
    {
        $this->dbName = $dbName;
    }

    public function getDbUser(): string
    {
        return $this->dbUser;
    }

    public function setDbUser(string $dbUser): void
    {
        $this->dbUser = $dbUser;
    }

    public function getDbPassword(): string
    {
        return $this->dbPassword;
    }

    public function setDbPassword(string $dbPassword): void
    {
        $this->dbPassword = $dbPassword;
    }

    public function getDbHost(): string
    {
        return $this->dbHost;
    }

    public function setDbHost(string $dbHost): void
    {
        $this->dbHost = $dbHost;
    }

    public function getDbPort(): string
    {
        return $this->dbPort;
    }

    public function setDbPort(string $dbPort): void
    {
        $this->dbPort = $dbPort;
    }

    public function getTablePrefix(): string
    {
        return $this->tablePrefix;
    }

    public function setTablePrefix(string $tablePrefix): void
    {
        $this->tablePrefix = $tablePrefix;
    }

    public function createDatabase(): bool
    {
        if ($this->databaseExists()) {
            return false;
        }

        try {
            // Créer la base de données
            $stmtCreateDb = $this->pdo->prepare("CREATE DATABASE :dbName");
            $stmtCreateDb->bindParam(':dbName', $this->dbName);
            $stmtCreateDb->execute();

            // Créer un utilisateur avec les privilèges sur la base de données
            $stmtCreateUser = $this->pdo->prepare("GRANT ALL PRIVILEGES ON DATABASE :dbName TO :dbUser");
            $stmtCreateUser->bindParam(':dbName', $this->dbName);
            $stmtCreateUser->bindParam(':dbUser', $this->dbUser);
            $stmtCreateUser->execute();

            return true;
        } catch (PDOException $e) {
            throw new \App\Exceptions\DatabaseException((string)$e->getMessage(), (int)$e->getCode(), $e);
        }
    }
    
    private function databaseExists(): bool
    {
        try {
            $stmt = $this->pdo->prepare("SELECT datname FROM pg_catalog.pg_database WHERE datname = :dbName");
            $stmt->bindParam(':dbName', $this->dbName);
            $stmt->execute();

            return ($stmt->fetchColumn() !== false);
        } catch (PDOException $e) {
            throw new \App\Exceptions\DatabaseException((string)$e->getMessage(), (int)$e->getCode(), $e);
        }
    }
}