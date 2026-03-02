<?php

namespace App\Utils;

class LocationUtil extends Util
{
    /**
     * Return list of countries
     *
     * @return array
     */
    public function allCountries()
    {
        return [
            'Cambodia' => 'Cambodia',
        ];
    }

    /**
     * Return list of states for a country
     *
     * @param string $country
     * @return array
     */
    public function getStates($country)
    {
        $states = [
            'Cambodia' => [
                'Banteay Meanchey' => 'Banteay Meanchey',
                'Battambang' => 'Battambang',
                'Kampong Cham' => 'Kampong Cham',
                'Kampong Chhnang' => 'Kampong Chhnang',
                'Kampong Speu' => 'Kampong Speu',
                'Kampong Thom' => 'Kampong Thom',
                'Kampot' => 'Kampot',
                'Kandal' => 'Kandal',
                'Koh Kong' => 'Koh Kong',
                'Kratie' => 'Kratie',
                'Mondulkiri' => 'Mondulkiri',
                'Oddar Meanchey' => 'Oddar Meanchey',
                'Preah Vihear' => 'Preah Vihear',
                'Pursat' => 'Pursat',
                'Prey Veng' => 'Prey Veng',
                'Ratanakiri' => 'Ratanakiri',
                'Siem Reap' => 'Siem Reap',
                'Stung Treng' => 'Stung Treng',
                'Svay Rieng' => 'Svay Rieng',
                'Takeo' => 'Takeo',
                'Kep' => 'Kep',
                'Pailin' => 'Pailin',
                'Phnom Penh' => 'Phnom Penh',
                'Preah Sihanouk' => 'Preah Sihanouk',
                'Tboung Khmum' => 'Tboung Khmum',
            ]
        ];

        return $states[$country] ?? [];
    }

    /**
     * Return list of cities for a state
     *
     * @param string $state
     * @return array
     */
    public function getCities($state)
    {
        $cities = [
            // Cambodia
            'Banteay Meanchey' => [
                'Mongkol Borei' => 'Mongkol Borei',
                'Phnum Srok' => 'Phnum Srok',
                'Preah Netr Preah' => 'Preah Netr Preah',
                'Ou Chrov' => 'Ou Chrov',
                'Krong Serei Saophoan' => 'Krong Serei Saophoan',
                'Thma Puok' => 'Thma Puok',
                'Svay Chek' => 'Svay Chek',
                'Malai' => 'Malai',
                'Krong Paoy Paet' => 'Krong Paoy Paet',
            ],
            'Battambang' => [
                'Banan' => 'Banan',
                'Thma Koul' => 'Thma Koul',
                'Krong Battambang' => 'Krong Battambang',
                'Bavel' => 'Bavel',
                'Ek Phnom' => 'Ek Phnom',
                'Moung Ruessi' => 'Moung Ruessi',
                'Rotanak Mondol' => 'Rotanak Mondol',
                'Sangkae' => 'Sangkae',
                'Samlout' => 'Samlout',
                'Sampov Loun' => 'Sampov Loun',
                'Phnum Proek' => 'Phnum Proek',
                'Kamrieng' => 'Kamrieng',
                'Koas Krala' => 'Koas Krala',
                'Rukhak Kiri' => 'Rukhak Kiri',
            ],
            'Kampong Cham' => [
                'Batheay' => 'Batheay',
                'Chamkar Leu' => 'Chamkar Leu',
                'Cheung Prey' => 'Cheung Prey',
                'Krong Kampong Cham' => 'Krong Kampong Cham',
                'Kampong Siem' => 'Kampong Siem',
                'Kang Meas' => 'Kang Meas',
                'Koh Sotin' => 'Koh Sotin',
                'Prey Chhor' => 'Prey Chhor',
                'Srey Santhor' => 'Srey Santhor',
                'Stueng Trang' => 'Stueng Trang',
            ],
            'Kampong Chhnang' => [
                'Baribour' => 'Baribour',
                'Chol Kiri' => 'Chol Kiri',
                'Krong Kampong Chhnang' => 'Krong Kampong Chhnang',
                'Kampong Leaeng' => 'Kampong Leaeng',
                'Kampong Tralach' => 'Kampong Tralach',
                'Rolea B\'ier' => 'Rolea B\'ier',
                'Sameakki Mean Chey' => 'Sameakki Mean Chey',
                'Tuek Phos' => 'Tuek Phos',
            ],
            'Kampong Speu' => [
                'Basedth' => 'Basedth',
                'Krong Chbar Mon' => 'Krong Chbar Mon',
                'Kong Pisei' => 'Kong Pisei',
                'Aoral' => 'Aoral',
                'Odongk' => 'Odongk',
                'Phnom Sruoch' => 'Phnom Sruoch',
                'Samraong Tong' => 'Samraong Tong',
                'Thpong' => 'Thpong',
            ],
            'Kampong Thom' => [
                'Baray' => 'Baray',
                'Kampong Svay' => 'Kampong Svay',
                'Krong Stueng Saen' => 'Krong Stueng Saen',
                'Prasat Balangk' => 'Prasat Balangk',
                'Prasat Sambour' => 'Prasat Sambour',
                'Sandaan' => 'Sandaan',
                'Santuk' => 'Santuk',
                'Stoung' => 'Stoung',
            ],
            'Kampot' => [
                'Angkor Chey' => 'Angkor Chey',
                'Banteay Meas' => 'Banteay Meas',
                'Chhuk' => 'Chhuk',
                'Chum Kiri' => 'Chum Kiri',
                'Dang Tong' => 'Dang Tong',
                'Kampong Trach' => 'Kampong Trach',
                'Tuek Chhou' => 'Tuek Chhou',
                'Krong Kampot' => 'Krong Kampot',
            ],
            'Kandal' => [
                'Kandal Stueng' => 'Kandal Stueng',
                'Kien Svay' => 'Kien Svay',
                'Khsach Kandal' => 'Khsach Kandal',
                'Kaoh Thum' => 'Kaoh Thum',
                'Leuk Daek' => 'Leuk Daek',
                'Lvea Aem' => 'Lvea Aem',
                'Mukh Kampul' => 'Mukh Kampul',
                'Angk Snuol' => 'Angk Snuol',
                'Ponhea Lueu' => 'Ponhea Lueu',
                'S\'ang' => 'S\'ang',
                'Krong Ta Khmau' => 'Krong Ta Khmau',
            ],
            'Koh Kong' => [
                'Botum Sakor' => 'Botum Sakor',
                'Kiri Sakor' => 'Kiri Sakor',
                'Krong Khemara Phoumin' => 'Krong Khemara Phoumin',
                'Smach Mean Chey' => 'Smach Mean Chey',
                'Mondol Seima' => 'Mondol Seima',
                'Srae Ambel' => 'Srae Ambel',
                'Thma Bang' => 'Thma Bang',
            ],
            'Kratie' => [
                'Chhloung' => 'Chhloung',
                'Krong Kracheh' => 'Krong Kracheh',
                'Preaek Prasab' => 'Preaek Prasab',
                'Sambour' => 'Sambour',
                'Snuol' => 'Snuol',
                'Chitr Borie' => 'Chitr Borie',
            ],
            'Mondulkiri' => [
                'Kaev Seima' => 'Kaev Seima',
                'Kaoh Nheaek' => 'Kaoh Nheaek',
                'Ou Reang' => 'Ou Reang',
                'Pechr Chenda' => 'Pechr Chenda',
                'Krong Saen Monourom' => 'Krong Saen Monourom',
            ],
            'Oddar Meanchey' => [
                'Anlong Veaeng' => 'Anlong Veaeng',
                'Banteay Ampil' => 'Banteay Ampil',
                'Chong Kal' => 'Chong Kal',
                'Krong Samraong' => 'Krong Samraong',
                'Trapeang Prasat' => 'Trapeang Prasat',
            ],
            'Preah Vihear' => [
                'Chey Saen' => 'Chey Saen',
                'Chhaeb' => 'Chhaeb',
                'Choam Khsant' => 'Choam Khsant',
                'Kuleaen' => 'Kuleaen',
                'Rovieng' => 'Rovieng',
                'Sangkom Thmei' => 'Sangkom Thmei',
                'Tbaeng Mean Chey' => 'Tbaeng Mean Chey',
            ],
            'Pursat' => [
                'Bakan' => 'Bakan',
                'Kandieng' => 'Kandieng',
                'Krakor' => 'Krakor',
                'Phnum Kravanh' => 'Phnum Kravanh',
                'Krong Pursat' => 'Krong Pursat',
                'Veal Veaeng' => 'Veal Veaeng',
            ],
            'Prey Veng' => [
                'Ba Phnum' => 'Ba Phnum',
                'Kamchay Mear' => 'Kamchay Mear',
                'Kampong Trabaek' => 'Kampong Trabaek',
                'Kanhchriech' => 'Kanhchriech',
                'Me Sang' => 'Me Sang',
                'Peam Chor' => 'Peam Chor',
                'Peam Ro' => 'Peam Ro',
                'Pea Reang' => 'Pea Reang',
                'Preah Sdach' => 'Preah Sdach',
                'Krong Prey Veaeng' => 'Krong Prey Veaeng',
                'Kampong Leav' => 'Kampong Leav',
                'Sithor Kandal' => 'Sithor Kandal',
            ],
            'Ratanakiri' => [
                'Andoung Meas' => 'Andoung Meas',
                'Krong Banlung' => 'Krong Banlung',
                'Bar Kaev' => 'Bar Kaev',
                'Koun Mom' => 'Koun Mom',
                'Lumphat' => 'Lumphat',
                'Ou Chum' => 'Ou Chum',
                'Ou Ya Dav' => 'Ou Ya Dav',
                'Ta Veaeng' => 'Ta Veaeng',
                'Veun Sai' => 'Veun Sai',
            ],
            'Siem Reap' => [
                'Angkor Chum' => 'Angkor Chum',
                'Angkor Thom' => 'Angkor Thom',
                'Banteay Srei' => 'Banteay Srei',
                'Chi Kraeng' => 'Chi Kraeng',
                'Kralanh' => 'Kralanh',
                'Puok' => 'Puok',
                'Prasat Bakong' => 'Prasat Bakong',
                'Krong Siem Reap' => 'Krong Siem Reap',
                'Sout Nikom' => 'Sout Nikom',
                'Srei Snam' => 'Srei Snam',
                'Svay Leu' => 'Svay Leu',
                'Varin' => 'Varin',
            ],
            'Stung Treng' => [
                'Sesan' => 'Sesan',
                'Siem Bouk' => 'Siem Bouk',
                'Siem Pang' => 'Siem Pang',
                'Krong Stung Treng' => 'Krong Stung Treng',
                'Thala Barivat' => 'Thala Barivat',
            ],
            'Svay Rieng' => [
                'Chantrea' => 'Chantrea',
                'Kampong Rou' => 'Kampong Rou',
                'Rumduol' => 'Rumduol',
                'Romeas Haek' => 'Romeas Haek',
                'Svay Chrum' => 'Svay Chrum',
                'Krong Svay Rieng' => 'Krong Svay Rieng',
                'Svay Teab' => 'Svay Teab',
                'Bavet' => 'Bavet',
            ],
            'Takeo' => [
                'Angkor Borei' => 'Angkor Borei',
                'Bati' => 'Bati',
                'Bourei Cholsar' => 'Bourei Cholsar',
                'Kiri Vong' => 'Kiri Vong',
                'Kaoh Andaet' => 'Kaoh Andaet',
                'Prey Kabbas' => 'Prey Kabbas',
                'Samraong' => 'Samraong',
                'Krong Doun Kaev' => 'Krong Doun Kaev',
                'Tram Kak' => 'Tram Kak',
                'Treang' => 'Treang',
            ],
            'Kep' => [
                'Damnak Chang\'aeur' => 'Damnak Chang\'aeur',
                'Krong Kep' => 'Krong Kep',
            ],
            'Pailin' => [
                'Krong Pailin' => 'Krong Pailin',
                'Sala Krau' => 'Sala Krau',
            ],
            'Phnom Penh' => [
                'Chamkar Mon' => 'Chamkar Mon',
                'Doun Penh' => 'Doun Penh',
                'Prampir Meakkakra' => 'Prampir Meakkakra',
                'Tuol Kouk' => 'Tuol Kouk',
                'Dangkao' => 'Dangkao',
                'Mean Chey' => 'Mean Chey',
                'Ruessei Kaev' => 'Ruessei Kaev',
                'Sen Sok' => 'Sen Sok',
                'Pou Senchey' => 'Pou Senchey',
                'Chrouy Changvar' => 'Chrouy Changvar',
                'Preaek Pnov' => 'Preaek Pnov',
                'Chbar Ampov' => 'Chbar Ampov',
            ],
            'Preah Sihanouk' => [
                'Krong Preah Sihanouk' => 'Krong Preah Sihanouk',
                'Prey Nob' => 'Prey Nob',
                'Stueng Hav' => 'Stueng Hav',
                'Kampong Seila' => 'Kampong Seila',
            ],
            'Tboung Khmum' => [
                'Dambae' => 'Dambae',
                'Krouch Chhmar' => 'Krouch Chhmar',
                'Memot' => 'Memot',
                'Ou Reang Ov' => 'Ou Reang Ov',
                'Ponhea Kraek' => 'Ponhea Kraek',
                'Tboung Khmum' => 'Tboung Khmum',
                'Krong Suong' => 'Krong Suong',
            ],
        ];

        return $cities[$state] ?? [];
    }
}
