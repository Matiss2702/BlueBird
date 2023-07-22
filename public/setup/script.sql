-- Adminer 4.8.1 PostgreSQL 15.3 (Debian 15.3-1.pgdg120+1) dump

DROP TABLE IF EXISTS "cnzj284_categorie_message";
DROP SEQUENCE IF EXISTS cnzj284_categorie_contact_id_seq;
CREATE SEQUENCE cnzj284_categorie_contact_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."cnzj284_categorie_message" (
    "id" integer DEFAULT nextval('cnzj284_categorie_contact_id_seq') NOT NULL,
    "description" character varying(255) NOT NULL,
    CONSTRAINT "cnzj284_categorie_contact_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "cnzj284_category_movie";
DROP SEQUENCE IF EXISTS cnzj284_movie_category_id_seq;
CREATE SEQUENCE cnzj284_movie_category_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."cnzj284_category_movie" (
    "id" integer DEFAULT nextval('cnzj284_movie_category_id_seq') NOT NULL,
    "name" character varying(100) NOT NULL,
    "created_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "updated_at" timestamp NOT NULL,
    CONSTRAINT "cnzj284_movie_category_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "cnzj284_comment";
DROP SEQUENCE IF EXISTS cnzj284_comment_id_seq;
CREATE SEQUENCE cnzj284_comment_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."cnzj284_comment" (
    "id" integer DEFAULT nextval('cnzj284_comment_id_seq') NOT NULL,
    "entity" character varying NOT NULL,
    "id_entity" integer NOT NULL,
    "id_user" integer NOT NULL,
    "content" character varying NOT NULL,
    "created_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "updated_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "id_status" integer NOT NULL,
    CONSTRAINT "cnzj284_comment_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "cnzj284_comment_reply";
DROP SEQUENCE IF EXISTS cnzj284_comment_answer_id_seq;
CREATE SEQUENCE cnzj284_comment_answer_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."cnzj284_comment_reply" (
    "id" integer DEFAULT nextval('cnzj284_comment_answer_id_seq') NOT NULL,
    "id_comment" integer NOT NULL,
    "id_user" integer NOT NULL,
    "content" character varying NOT NULL,
    "created_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "updated_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "id_status" smallint NOT NULL,
    CONSTRAINT "cnzj284_comment_answer_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "cnzj284_comment_status";
DROP SEQUENCE IF EXISTS cnzj284_comment_status_id_seq;
CREATE SEQUENCE cnzj284_comment_status_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."cnzj284_comment_status" (
    "id" integer DEFAULT nextval('cnzj284_comment_status_id_seq') NOT NULL,
    "intitule" character varying NOT NULL,
    CONSTRAINT "cnzj284_comment_status_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "cnzj284_country";
DROP SEQUENCE IF EXISTS country_id_seq1;
CREATE SEQUENCE country_id_seq1 INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."cnzj284_country" (
    "id" integer DEFAULT nextval('country_id_seq1') NOT NULL,
    "iso" character(2) NOT NULL,
    "name" character varying(80) NOT NULL,
    "nicename" character varying(80) NOT NULL,
    "iso3" character(3),
    "numcode" smallint,
    "phonecode" integer NOT NULL,
    CONSTRAINT "country_pkey1" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "cnzj284_email_activation_token";
DROP SEQUENCE IF EXISTS email_activation_tokens_id_seq;
CREATE SEQUENCE email_activation_tokens_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."cnzj284_email_activation_token" (
    "id" integer DEFAULT nextval('email_activation_tokens_id_seq') NOT NULL,
    "id_user" integer NOT NULL,
    "token" character varying(255) NOT NULL,
    "verified_at" timestamp,
    "created_at" timestamp DEFAULT CURRENT_TIMESTAMP,
    "updated_at" timestamp DEFAULT CURRENT_TIMESTAMP,
    "sent_at" timestamp,
    "verified_by_admin" smallint DEFAULT '0' NOT NULL,
    CONSTRAINT "email_activation_tokens_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "cnzj284_forgot_password";
DROP SEQUENCE IF EXISTS forgot_password_request_id_seq;
CREATE SEQUENCE forgot_password_request_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."cnzj284_forgot_password" (
    "id" integer DEFAULT nextval('forgot_password_request_id_seq') NOT NULL,
    "id_user" integer NOT NULL,
    "token" character varying(256) NOT NULL,
    "created_at" timestamp NOT NULL,
    "send_at" timestamp,
    "completed_at" timestamp,
    CONSTRAINT "forgot_password_request_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "cnzj284_job";
DROP SEQUENCE IF EXISTS cnzj284_job_id_seq;
CREATE SEQUENCE cnzj284_job_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."cnzj284_job" (
    "id" integer DEFAULT nextval('cnzj284_job_id_seq') NOT NULL,
    "name" character varying(100) NOT NULL,
    "created_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT "cnzj284_job_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "cnzj284_message";
DROP SEQUENCE IF EXISTS cnzj284_contact_id_seq;
CREATE SEQUENCE cnzj284_contact_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."cnzj284_message" (
    "id" integer DEFAULT nextval('cnzj284_contact_id_seq') NOT NULL,
    "object" character varying(255) NOT NULL,
    "message" character varying(255) NOT NULL,
    "firstname" character varying(255) NOT NULL,
    "lastname" character varying(255) NOT NULL,
    "email" character varying(255) NOT NULL,
    "created_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "update_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "id_categorie_message" integer NOT NULL,
    CONSTRAINT "cnzj284_contact_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "cnzj284_movie";
DROP SEQUENCE IF EXISTS cnzj284_movie_id_seq;
CREATE SEQUENCE cnzj284_movie_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."cnzj284_movie" (
    "id" integer DEFAULT nextval('cnzj284_movie_id_seq') NOT NULL,
    "title" character varying(200) NOT NULL,
    "description" character varying(2000) NOT NULL,
    "release_date" date NOT NULL,
    "duration" integer NOT NULL,
    "created_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "updated_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT "cnzj284_movie_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "cnzj284_movie_category_movie";
DROP SEQUENCE IF EXISTS cnzj284_movie_category_movie_id_seq;
CREATE SEQUENCE cnzj284_movie_category_movie_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."cnzj284_movie_category_movie" (
    "id" integer DEFAULT nextval('cnzj284_movie_category_movie_id_seq') NOT NULL,
    "id_movie" integer NOT NULL,
    "id_category_movie" integer NOT NULL,
    CONSTRAINT "cnzj284_movie_category_movie_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "cnzj284_page";
DROP SEQUENCE IF EXISTS cnjz284_page_id_seq;
CREATE SEQUENCE cnjz284_page_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."cnzj284_page" (
    "id" integer DEFAULT nextval('cnjz284_page_id_seq') NOT NULL,
    "created_at" timestamp DEFAULT CURRENT_TIMESTAMP,
    "header_title" character varying,
    "header_description" text,
    "main_title" character varying,
    "main_content" text,
    "sidebar_title" character varying,
    "sidebar_content" text,
    CONSTRAINT "cnjz284_page_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "cnzj284_post";
DROP SEQUENCE IF EXISTS cnjz284_post_id_seq;
CREATE SEQUENCE cnjz284_post_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."cnzj284_post" (
    "id" integer DEFAULT nextval('cnjz284_post_id_seq') NOT NULL,
    "title" character varying(255) NOT NULL,
    "content" text,
    "created_at" timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT "cnjz284_post_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "cnzj284_productor";
DROP SEQUENCE IF EXISTS cnzj284_studio_id_seq;
CREATE SEQUENCE cnzj284_studio_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."cnzj284_productor" (
    "id" integer DEFAULT nextval('cnzj284_studio_id_seq') NOT NULL,
    "name" character varying(200) NOT NULL,
    "description" character varying(2000) NOT NULL,
    "id_country" integer,
    CONSTRAINT "cnzj284_productor_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "cnzj284_review";
DROP SEQUENCE IF EXISTS cnzj284_review_id_seq;
CREATE SEQUENCE cnzj284_review_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."cnzj284_review" (
    "id" integer DEFAULT nextval('cnzj284_review_id_seq') NOT NULL,
    "rate" integer NOT NULL,
    "comment" text,
    "id_movie" integer NOT NULL,
    "id_user" integer NOT NULL,
    "created_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT "cnzj284_review_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "cnzj284_role";
DROP SEQUENCE IF EXISTS cnzj284_role_id_seq;
CREATE SEQUENCE cnzj284_role_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."cnzj284_role" (
    "id" integer DEFAULT nextval('cnzj284_role_id_seq') NOT NULL,
    "name" character varying(20) NOT NULL,
    CONSTRAINT "cnzj284_role_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "cnzj284_staff";
DROP SEQUENCE IF EXISTS cnzj284_staff_id_seq;
CREATE SEQUENCE cnzj284_staff_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."cnzj284_staff" (
    "id" integer DEFAULT nextval('cnzj284_staff_id_seq') NOT NULL,
    "firstname" character varying(50) NOT NULL,
    "lastname" character varying(50) NOT NULL,
    "birthdate" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "birthplace" character varying NOT NULL,
    "nationality" character varying NOT NULL,
    "biography" text NOT NULL,
    "created_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT "cnzj284_staff_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "cnzj284_staff_job";
DROP SEQUENCE IF EXISTS cnzj284_staff_job_id_seq;
CREATE SEQUENCE cnzj284_staff_job_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."cnzj284_staff_job" (
    "id" integer DEFAULT nextval('cnzj284_staff_job_id_seq') NOT NULL,
    "id_staff" integer NOT NULL,
    "id_job" integer NOT NULL,
    CONSTRAINT "cnzj284_staff_job_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "cnzj284_template_one";
DROP SEQUENCE IF EXISTS cnzj284_template_one_id_seq;
CREATE SEQUENCE cnzj284_template_one_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."cnzj284_template_one" (
    "id" integer DEFAULT nextval('cnzj284_template_one_id_seq') NOT NULL,
    "created_at" timestamp DEFAULT CURRENT_TIMESTAMP,
    "title" character varying,
    "subtitle" character varying,
    "about_title" character varying,
    "about_desc" text,
    "about_img" character varying,
    "main_bloc_title" character varying,
    "main_bloc_desc" text,
    "main_bloc_img" character varying,
    "bloc_one_title" character varying,
    "bloc_one_desc" text,
    "bloc_one_img" character varying,
    "bloc_two_title" character varying,
    "bloc_two_desc" text,
    "bloc_two_img" character varying,
    "address" character varying,
    "email" character varying,
    "phone" character varying,
    "slug" character varying,
    CONSTRAINT "cnzj284_template_one_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "cnzj284_user";
DROP SEQUENCE IF EXISTS cnzj284_user_id_seq;
CREATE SEQUENCE cnzj284_user_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."cnzj284_user" (
    "id" integer DEFAULT nextval('cnzj284_user_id_seq') NOT NULL,
    "firstname" character varying(60) NOT NULL,
    "lastname" character varying(120) NOT NULL,
    "email" character varying(255) NOT NULL,
    "password" character varying(255) NOT NULL,
    "status" integer NOT NULL,
    "created_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "updated_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT "cnzj284_user_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "unique_email" UNIQUE ("email")
) WITH (oids = false);


DROP TABLE IF EXISTS "cnzj284_user_address";
DROP SEQUENCE IF EXISTS cnzj284_user_address_id_seq;
CREATE SEQUENCE cnzj284_user_address_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."cnzj284_user_address" (
    "id" integer DEFAULT nextval('cnzj284_user_address_id_seq') NOT NULL,
    "number" integer NOT NULL,
    "type" character varying NOT NULL,
    "street" character varying NOT NULL,
    "zip_code" integer NOT NULL,
    "id_country" integer NOT NULL,
    "id_user" integer NOT NULL,
    CONSTRAINT "cnzj284_user_address_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "cnzj284_user_role";
DROP SEQUENCE IF EXISTS cnzj284_user_role_id_seq;
CREATE SEQUENCE cnzj284_user_role_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."cnzj284_user_role" (
    "id" integer DEFAULT nextval('cnzj284_user_role_id_seq') NOT NULL,
    "id_user" integer NOT NULL,
    "id_role" integer NOT NULL,
    CONSTRAINT "cnzj284_user_role_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


ALTER TABLE ONLY "public"."cnzj284_comment" ADD CONSTRAINT "cnzj284_comment_id_status_fkey" FOREIGN KEY (id_status) REFERENCES cnzj284_comment_status(id) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."cnzj284_comment" ADD CONSTRAINT "cnzj284_comment_id_user_fkey" FOREIGN KEY (id_user) REFERENCES cnzj284_user(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."cnzj284_comment_reply" ADD CONSTRAINT "cnzj284_comment_answer_id_comment_fkey" FOREIGN KEY (id_comment) REFERENCES cnzj284_comment(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;
ALTER TABLE ONLY "public"."cnzj284_comment_reply" ADD CONSTRAINT "cnzj284_comment_answer_id_user_fkey" FOREIGN KEY (id_user) REFERENCES cnzj284_user(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;
ALTER TABLE ONLY "public"."cnzj284_comment_reply" ADD CONSTRAINT "cnzj284_comment_reply_id_status_fkey" FOREIGN KEY (id_status) REFERENCES cnzj284_comment_status(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."cnzj284_email_activation_token" ADD CONSTRAINT "cnzj284_email_activation_token_id_user_fkey" FOREIGN KEY (id_user) REFERENCES cnzj284_user(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."cnzj284_message" ADD CONSTRAINT "cnzj284_message_id_categorie_message_fkey" FOREIGN KEY (id_categorie_message) REFERENCES cnzj284_categorie_message(id) ON UPDATE SET NULL ON DELETE SET NULL NOT DEFERRABLE;

ALTER TABLE ONLY "public"."cnzj284_movie_category_movie" ADD CONSTRAINT "cnzj284_movie_category_movie_id_category_movie_fkey" FOREIGN KEY (id_category_movie) REFERENCES cnzj284_category_movie(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;
ALTER TABLE ONLY "public"."cnzj284_movie_category_movie" ADD CONSTRAINT "cnzj284_movie_category_movie_id_movie_fkey" FOREIGN KEY (id_movie) REFERENCES cnzj284_movie(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."cnzj284_productor" ADD CONSTRAINT "cnzj284_productor_id_country_fkey" FOREIGN KEY (id_country) REFERENCES cnzj284_country(id) ON UPDATE SET NULL ON DELETE SET NULL NOT DEFERRABLE;

ALTER TABLE ONLY "public"."cnzj284_review" ADD CONSTRAINT "cnzj284_review_id_movie_fkey" FOREIGN KEY (id_movie) REFERENCES cnzj284_movie(id) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."cnzj284_review" ADD CONSTRAINT "cnzj284_review_id_user_fkey" FOREIGN KEY (id_user) REFERENCES cnzj284_user(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."cnzj284_staff_job" ADD CONSTRAINT "cnzj284_staff_job_id_job_fkey" FOREIGN KEY (id_job) REFERENCES cnzj284_job(id) ON DELETE CASCADE NOT DEFERRABLE;
ALTER TABLE ONLY "public"."cnzj284_staff_job" ADD CONSTRAINT "cnzj284_staff_job_id_staff_fkey" FOREIGN KEY (id_staff) REFERENCES cnzj284_staff(id) ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."cnzj284_user_address" ADD CONSTRAINT "cnzj284_user_address_id_country_fkey" FOREIGN KEY (id_country) REFERENCES cnzj284_country(id) ON UPDATE SET NULL ON DELETE SET NULL NOT DEFERRABLE;

ALTER TABLE ONLY "public"."cnzj284_user_role" ADD CONSTRAINT "cnzj284_user_role_id_role_fkey" FOREIGN KEY (id_role) REFERENCES cnzj284_role(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;
ALTER TABLE ONLY "public"."cnzj284_user_role" ADD CONSTRAINT "cnzj284_user_role_id_user_fkey" FOREIGN KEY (id_user) REFERENCES cnzj284_user(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;

-- 2023-07-21 11:38:26.385794+00