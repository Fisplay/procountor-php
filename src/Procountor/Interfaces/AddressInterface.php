<?php

namespace Procountor\Procountor\Interfaces;

interface AddressInterface extends AbstractResourceInterface
{
    // Name ("first line") in the address. Max length 80. ,
    public function getName(): string;

    // Specifier, such as c/o address. Max length 80. ,
    public function getSpecifier(): ?string;

    // Street. Required for SALES_INVOICE if invoicing channel is MAIL. In that case, must be specified in counterPartyAddress if not specified in billingAddress. Max length 80. ,
    public function getStreet(): ?string;

    // Zip code. Required for SALES_INVOICE if invoicing channel is MAIL. In that case, must be specified in counterPartyAddress if not specified in billingAddress. Max length 20. ,
    public function getZip(): ?string;


    // City. Max length 40. ,
    public function getCity(): ?string;

    // ['AFGHANISTAN', 'ALBANIA', 'ALGERIA', 'AMERICAN_SAMOA', 'ANDORRA', 'ANGOLA', 'ANGUILLA', 'ANTARCTICA', 'ANTIGUA_AND_BARBUDA', 'ARGENTINA', 'ARMENIA', 'ARUBA', 'AUSTRALIA', 'AUSTRIA', 'AZERBAIJAN', 'BAHAMAS', 'BAHRAIN', 'BANGLADESH', 'BARBADOS', 'BELARUS', 'BELGIUM', 'BELIZE', 'BENIN', 'BERMUDA', 'BHUTAN', 'PLURINATIONAL_STATE_OF_BOLIVIA', 'SINT_EUSTATIUS_AND_SABA_BONAIRE', 'BOSNIA_AND_HERZEGOVINA', 'BOTSWANA', 'BOUVET_ISLAND', 'BRAZIL', 'BRITISH_INDIAN_OCEAN_TERRITORY', 'BRUNEI_DARUSSALAM', 'BULGARIA', 'BURKINA_FASO', 'BURUNDI', 'CABO_VERDE', 'CAMBODIA', 'CAMEROON', 'CANADA', 'CAYMAN_ISLANDS', 'CENTRAL_AFRICAN_REPUBLIC', 'CHAD', 'CHILE', 'CHINA', 'CHRISTMAS_ISLAND', 'COCOS_KEELING_ISLANDS', 'COLOMBIA', 'COMOROS', 'CONGO', 'THE_DEMOCRATIC_REPUBLIC_OF_THE_CONGO', 'COOK_ISLANDS', 'COSTA_RICA', 'CROATIA', 'CUBA', 'CURACAO', 'CYPRUS', 'CZECH_REPUBLIC', 'COTE_D_IVOIRE', 'DENMARK', 'DJIBOUTI', 'DOMINICA', 'DOMINICAN_REPUBLIC', 'ECUADOR', 'EGYPT', 'EL_SALVADOR', 'EQUATORIAL_GUINEA', 'ERITREA', 'ESTONIA', 'ETHIOPIA', 'FALKLAND_ISLANDS_MALVINAS', 'FAROE_ISLANDS', 'FIJI', 'FINLAND', 'FRANCE', 'FRENCH_GUIANA', 'FRENCH_POLYNESIA', 'FRENCH_SOUTHERN_TERRITORIES', 'GABON', 'GAMBIA', 'GEORGIA', 'GERMANY', 'GHANA', 'GIBRALTAR', 'GREECE', 'GREENLAND', 'GRENADA', 'GUADELOUPE', 'GUAM', 'GUATEMALA', 'GUERNSEY', 'GUINEA', 'GUINEA_BISSAU', 'GUYANA', 'HAITI', 'HEARD_ISLAND_AND_MCDONALD_ISLANDS', 'HOLY_SEE_VATICAN_CITY_STATE', 'HONDURAS', 'HONG_KONG', 'HUNGARY', 'ICELAND', 'INDIA', 'INDONESIA', 'ISLAMIC_REPUBLIC_OF_IRAN', 'IRAQ', 'IRELAND', 'ISLE_OF_MAN', 'ISRAEL', 'ITALY', 'JAMAICA', 'JAPAN', 'JERSEY', 'JORDAN', 'KAZAKHSTAN', 'KENYA', 'KIRIBATI', 'DEMOCRATIC_PEOPLE_S_REPUBLIC_OF_KOREA', 'REPUBLIC_OF_KOREA', 'KUWAIT', 'KYRGYZSTAN', 'LAO_PEOPLE_S_DEMOCRATIC_REPUBLIC', 'LATVIA', 'LEBANON', 'LESOTHO', 'LIBERIA', 'LIBYA', 'LIECHTENSTEIN', 'LITHUANIA', 'LUXEMBOURG', 'MACAO', 'THE_FORMER_YUGOSLAV_REPUBLIC_OF_MACEDONIA', 'MADAGASCAR', 'MALAWI', 'MALAYSIA', 'MALDIVES', 'MALI', 'MALTA', 'MARSHALL_ISLANDS', 'MARTINIQUE', 'MAURITANIA', 'MAURITIUS', 'MAYOTTE', 'MEXICO', 'FEDERATED_STATES_OF_MICRONESIA', 'REPUBLIC_OF_MOLDOVA', 'MONACO', 'MONGOLIA', 'MONTENEGRO', 'MONTSERRAT', 'MOROCCO', 'MOZAMBIQUE', 'MYANMAR', 'NAMIBIA', 'NAURU', 'NEPAL', 'NETHERLANDS', 'NEW_CALEDONIA', 'NEW_ZEALAND', 'NICARAGUA', 'NIGER', 'NIGERIA', 'NIUE', 'NORFOLK_ISLAND', 'NORTHERN_MARIANA_ISLANDS', 'NORWAY', 'OMAN', 'PAKISTAN', 'PALAU', 'STATE_OF_PALESTINE', 'PANAMA', 'PAPUA_NEW_GUINEA', 'PARAGUAY', 'PERU', 'PHILIPPINES', 'PITCAIRN', 'POLAND', 'PORTUGAL', 'PUERTO_RICO', 'QATAR', 'ROMANIA', 'RUSSIAN_FEDERATION', 'RWANDA', 'REUNION', 'SAINT_BARTHELEMY', 'ASCENSION_AND_TRISTAN_DA_CUNHA_SAINT_HELENA', 'SAINT_KITTS_AND_NEVIS', 'SAINT_LUCIA', 'SAINT_MARTIN_FRENCH_PART', 'SAINT_PIERRE_AND_MIQUELON', 'SAINT_VINCENT_AND_THE_GRENADINES', 'SAMOA', 'SAN_MARINO', 'SAO_TOME_AND_PRINCIPE', 'SAUDI_ARABIA', 'SENEGAL', 'SERBIA', 'SEYCHELLES', 'SIERRA_LEONE', 'SINGAPORE', 'SINT_MAARTEN_DUTCH_PART', 'SLOVAKIA', 'SLOVENIA', 'SOLOMON_ISLANDS', 'SOMALIA', 'SOUTH_AFRICA', 'SOUTH_GEORGIA_AND_THE_SOUTH_SANDWICH_ISLANDS', 'SOUTH_SUDAN', 'SPAIN', 'SRI_LANKA', 'SUDAN', 'SURINAME', 'SVALBARD_AND_JAN_MAYEN', 'SWAZILAND', 'SWEDEN', 'SWITZERLAND', 'SYRIAN_ARAB_REPUBLIC', 'PROVINCE_OF_CHINA_TAIWAN', 'TAJIKISTAN', 'UNITED_REPUBLIC_OF_TANZANIA', 'THAILAND', 'TIMOR_LESTE', 'TOGO', 'TOKELAU', 'TONGA', 'TRINIDAD_AND_TOBAGO', 'TUNISIA', 'TURKEY', 'TURKMENISTAN', 'TURKS_AND_CAICOS_ISLANDS', 'TUVALU', 'UGANDA', 'UKRAINE', 'UNITED_ARAB_EMIRATES', 'UNITED_KINGDOM_OF_GREAT_BRITAIN_AND_NORTHERN_IRELAND', 'UNITED_STATES_MINOR_OUTLYING_ISLANDS', 'UNITED_STATES_OF_AMERICA', 'URUGUAY', 'UZBEKISTAN', 'VANUATU', 'BOLIVARIAN_REPUBLIC_OF_VENEZUELA', 'VIET_NAM', 'BRITISH_VIRGIN_ISLANDS', 'U_S_VIRGIN_ISLANDS', 'WALLIS_AND_FUTUNA', 'WESTERN_SAHARA', 'YEMEN', 'ZAMBIA', 'ZIMBABWE', 'ALAND_ISLANDS']
    public function getCountry(): ?string;
}
