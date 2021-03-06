<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'travel');
define('DB_PORT', '3306');
define('DB_USER', 'tr_agent');
define('DB_PASS', '010djqnb050');
define('TB_COUNTRIES', 'countries');
define('TB_CITIES', 'cities');
define('TB_HOTELS', 'hotels');

//use PDO;

class Common {

    private static $db;

    static function DB() {

        if (self::$db == null) {
            try
            {
                $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';port=' . DB_PORT . ';';
                self::$db = new PDO($dsn, DB_USER, DB_PASS);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch (\PDOException $ex)
            {
                echo ($ex->getMessage());
            }
        }
    }

    static function getAllCountries() {
        self::DB();
        $_tb = TB_COUNTRIES;
        $stmt = self::$db->prepare("SELECT * FROM $_tb ORDER BY countryName");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    static function addNewCountry($country) {
        $_tb = TB_COUNTRIES;
        self::DB();
        $sql = "INSERT INTO $_tb (countryName) 
                VALUES (:countryName)";
        $stmt = self::$db->prepare($sql);

        return $stmt->execute([
            ':countryName' => $country
        ]);
    }

    static function getCountryById($id) {
        $_tb = TB_COUNTRIES;
        self::DB();
        $sql = "SELECT * FROM $_tb WHERE id = :_id";
        $stmt = self::$db->prepare($sql);
        $stmt->execute([
            ':_id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    static function updateCountryById($id, $country) {
        $_tb = TB_COUNTRIES;
        self::DB();
        $sql = "UPDATE $_tb SET countryName = :country
                WHERE id = :_id";
        $stmt = self::$db->prepare($sql);
        return $stmt->execute([
            ':_id' => $id,
            ':country' => $country
        ]);
    }

    static function deleteCountryById($id) {
        $_tb = TB_COUNTRIES;
        self::DB();
        $sql = "DELETE FROM $_tb WHERE id = :_id";
        $stmt = self::$db->prepare($sql);
        $stmt->execute([
            ':_id' => $id,
        ]);

        return $stmt->rowCount();
    }

    static function getCountryCities($id) {
        self::DB();
        $_tb = TB_CITIES;
        $stmt = self::$db->prepare("SELECT * FROM $_tb WHERE countryId = $id ORDER BY cityName");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    static function createNewCity($city) {
        $_tb = TB_CITIES;
        self::DB();
        $sql = "INSERT INTO $_tb (cityName, countryId) 
                VALUES (:cityName, :countryId)";
        $stmt = self::$db->prepare($sql);

        return $stmt->execute([
            ':cityName' => $city['cityName'],
            ':countryId' => $city['countryId']
        ]);
    }

    static function updateCityById($city) {
        $_tb = TB_CITIES;
        self::DB();
        $sql = "UPDATE $_tb SET cityName = :cityName, countryId = :countryId
                WHERE id = :_id";
        $stmt = self::$db->prepare($sql);
        return $stmt->execute([
            ':_id' => $city['id'],
            ':cityName' => $city['cityName'],
            ':countryId' => $city['countryId']
        ]);
    }

    static function deleteCity($id) {
        $_tb = TB_CITIES;
        self::DB();
        $sql = "DELETE FROM $_tb WHERE id = :_id";
        $stmt = self::$db->prepare($sql);
        $stmt->execute([
            ':_id' => $id,
        ]);

        return $stmt->rowCount();
    }

    static function getCityHotels($countryId, $cityId) {
        self::DB();
        $_tb = TB_HOTELS;
        $sql = "SELECT * FROM $_tb 
WHERE countryId = :_countryId AND cityId = :_cityId
ORDER BY hotelName";
        $stmt = self::$db->prepare($sql);

        $stmt->execute([
            ':_countryId' => $countryId,
            ':_cityId' => $cityId
        ]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    static function createNewHotel($hotel) {
        $_tb = TB_HOTELS;
        self::DB();
        $sql = "INSERT INTO $_tb (hotelName, stars, cost, countryId, cityId, info) 
                VALUES (:hotelName, :stars, :cost, :countryId, :cityId, :info)";
        $stmt = self::$db->prepare($sql);

        return $stmt->execute([
            ':hotelName' => $hotel['hotelName'],
            ':stars' => $hotel['stars'],
            ':cost' => $hotel['cost'],
            ':countryId' => $hotel['countryId'],
            ':cityId' => $hotel['cityId'],
            ':info' => $hotel['info']
        ]);
    }

    static function updateHotelById($hotel) {
        $_tb = TB_HOTELS;
        self::DB();
        $sql = "UPDATE $_tb SET 
hotelName = :hotelName, stars = :stars, cost = :cost, countryId = :countryId, info = :info
                WHERE id = :_id";
        $stmt = self::$db->prepare($sql);
        return $stmt->execute([
            ':_id' => $hotel['id'],
            ':hotelName' => $hotel['hotelName'],
            ':stars' => $hotel['stars'],
            ':cost' => $hotel['cost'],
            ':countryId' => $hotel['countryId'],
            ':info' => $hotel['info']
        ]);
    }

    static function deleteHotel($id) {
        $_tb = TB_HOTELS;
        self::DB();
        $sql = "DELETE FROM $_tb WHERE id = :_id";
        $stmt = self::$db->prepare($sql);
        $stmt->execute([
            ':_id' => $id,
        ]);

        return $stmt->rowCount();
    }
}