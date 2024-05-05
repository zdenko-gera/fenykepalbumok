CREATE OR REPLACE TRIGGER prevent_duplicate_city
BEFORE INSERT ON LOCATIONS
FOR EACH ROW
DECLARE
    city_count NUMBER;
BEGIN
    SELECT COUNT(*) INTO city_count
    FROM LOCATIONS
    WHERE CITY = :NEW.CITY;

    IF city_count > 0 THEN
        RAISE_APPLICATION_ERROR(-20001, 'Ez a város már szerepel az adatbázisban.');
    END IF;
END;
/