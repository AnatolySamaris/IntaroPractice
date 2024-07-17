<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240712131454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('CREATE TABLE places (id_place SERIAL NOT NULL, id_city INT DEFAULT NULL, photo_place VARCHAR(255) DEFAULT NULL, name_place VARCHAR(1000) NOT NULL, url_place VARCHAR(1000) DEFAULT NULL, favorites_count INT NOT NULL, desc_place VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id_place))');
        $this->addSql('CREATE UNIQUE INDEX places_pk ON places (id_place)');
        $this->addSql('CREATE INDEX IDX_FEAF6C55A67B1E36 ON places (id_city)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('CREATE TABLE users (id_user SERIAL NOT NULL, full_name_user VARCHAR(100) NOT NULL, email_user VARCHAR(100) NOT NULL, password_user VARCHAR(255) NOT NULL, role_user VARCHAR(100) NOT NULL, photo_user VARCHAR(100) DEFAULT NULL, news_mailing BOOLEAN NOT NULL, phone_user VARCHAR(20) DEFAULT NULL, birth_user DATE DEFAULT NULL, date_mail DATE DEFAULT NULL, PRIMARY KEY(id_user))');
        $this->addSql('CREATE UNIQUE INDEX user_pk ON users (id_user)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('CREATE TABLE ml_request (id_ml_request SERIAL NOT NULL, id_user INT DEFAULT NULL, id_city INT DEFAULT NULL, price_request NUMERIC(10, 0) DEFAULT NULL, class_request VARCHAR(255) DEFAULT NULL, position_request VARCHAR(255) DEFAULT NULL, amount_stops_request INT DEFAULT NULL, date_arr_request TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, date_dep_request TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id_ml_request))');
        $this->addSql('CREATE INDEX IDX_5739248DA67B1E36 ON ml_request (id_city)');
        $this->addSql('CREATE INDEX IDX_5739248D6B3CA4B ON ml_request (id_user)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('CREATE TABLE flight (id_flight SERIAL NOT NULL, id_user INT DEFAULT NULL, id_city INT DEFAULT NULL, from_flight VARCHAR(70) DEFAULT NULL, date_dep_flight TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, airline_flight VARCHAR(70) DEFAULT NULL, time_taken_flight VARCHAR(100) DEFAULT NULL, price INT DEFAULT NULL, amount_stops INT DEFAULT NULL, date_arr_flight TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, econom_class BOOLEAN DEFAULT NULL, PRIMARY KEY(id_flight))');
        $this->addSql('CREATE UNIQUE INDEX flight_pk ON flight (id_flight)');
        $this->addSql('CREATE INDEX also_has_fk ON flight (id_user)');
        $this->addSql('CREATE INDEX IDX_C257E60EA67B1E36 ON flight (id_city)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('CREATE TABLE city (id_city SERIAL NOT NULL, name_city VARCHAR(100) DEFAULT NULL, amount_views_city INT DEFAULT NULL, photo_city VARCHAR(255) DEFAULT NULL, desc_city TEXT DEFAULT NULL, PRIMARY KEY(id_city))');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('CREATE TABLE request_history (id_request_history SERIAL NOT NULL, id_user INT DEFAULT NULL, id_flight INT DEFAULT NULL, view_date DATE DEFAULT NULL, PRIMARY KEY(id_request_history))');
        $this->addSql('CREATE UNIQUE INDEX request_history_pk ON request_history (id_request_history)');
        $this->addSql('CREATE INDEX include_fk ON request_history (id_flight)');
        $this->addSql('CREATE INDEX has_fk ON request_history (id_user)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('CREATE TABLE ml_request_history (id_ml_history SERIAL NOT NULL, id_user INT DEFAULT NULL, id_ml_request INT DEFAULT NULL, view_date DATE DEFAULT NULL, PRIMARY KEY(id_ml_history))');
        $this->addSql('CREATE INDEX IDX_978590CF2B3A45A ON ml_request_history (id_ml_request)');
        $this->addSql('CREATE INDEX IDX_978590C6B3CA4B ON ml_request_history (id_user)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('CREATE TABLE favorites (id_favorites SERIAL NOT NULL, id_place INT DEFAULT NULL, id_user INT DEFAULT NULL, PRIMARY KEY(id_favorites))');
        $this->addSql('CREATE INDEX have_fk ON favorites (id_user)');
        $this->addSql('CREATE UNIQUE INDEX favorites_pk ON favorites (id_favorites)');
        $this->addSql('CREATE INDEX are_included_fk ON favorites (id_place)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('DROP TABLE places');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('DROP TABLE users');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('DROP TABLE ml_request');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('DROP TABLE flight');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('DROP TABLE city');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('DROP TABLE request_history');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('DROP TABLE ml_request_history');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('DROP TABLE favorites');
    }
}
