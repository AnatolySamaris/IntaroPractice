--
-- PostgreSQL database dump
--

-- Dumped from database version 15.3
-- Dumped by pg_dump version 15.3

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: city; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.city (
    id_city integer NOT NULL,
    name_city character varying(100) DEFAULT NULL::character varying,
    amount_views_city integer,
    photo_city character varying(255) DEFAULT NULL::character varying,
    desc_city text
);


ALTER TABLE public.city OWNER TO "user";

--
-- Name: city_id_city_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.city_id_city_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.city_id_city_seq OWNER TO "user";

--
-- Name: city_id_city_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user
--

ALTER SEQUENCE public.city_id_city_seq OWNED BY public.city.id_city;


--
-- Name: doctrine_migration_versions; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.doctrine_migration_versions (
    version character varying(191) NOT NULL,
    executed_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    execution_time integer
);


ALTER TABLE public.doctrine_migration_versions OWNER TO "user";

--
-- Name: favorites; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.favorites (
    id_favorites integer NOT NULL,
    id_place integer,
    id_user integer
);


ALTER TABLE public.favorites OWNER TO "user";

--
-- Name: favorites_id_favorites_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.favorites_id_favorites_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.favorites_id_favorites_seq OWNER TO "user";

--
-- Name: favorites_id_favorites_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user
--

ALTER SEQUENCE public.favorites_id_favorites_seq OWNED BY public.favorites.id_favorites;


--
-- Name: flight; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.flight (
    id_flight integer NOT NULL,
    id_user integer,
    id_city integer,
    from_flight character varying(70) DEFAULT NULL::character varying,
    date_dep_flight timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    airline_flight character varying(70) DEFAULT NULL::character varying,
    time_taken_flight character varying(100) DEFAULT NULL::character varying,
    price integer,
    amount_stops integer,
    date_arr_flight timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    econom_class boolean
);


ALTER TABLE public.flight OWNER TO "user";

--
-- Name: flight_id_flight_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.flight_id_flight_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.flight_id_flight_seq OWNER TO "user";

--
-- Name: flight_id_flight_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user
--

ALTER SEQUENCE public.flight_id_flight_seq OWNED BY public.flight.id_flight;


--
-- Name: ml_request; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.ml_request (
    id_ml_request integer NOT NULL,
    id_user integer,
    id_city integer,
    price_request numeric(10,0) DEFAULT NULL::numeric,
    class_request character varying(255) DEFAULT NULL::character varying,
    position_request character varying(255) DEFAULT NULL::character varying,
    amount_stops_request integer,
    date_arr_request timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    date_dep_request timestamp(0) without time zone DEFAULT NULL::timestamp without time zone
);


ALTER TABLE public.ml_request OWNER TO "user";

--
-- Name: ml_request_history; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.ml_request_history (
    id_ml_history integer NOT NULL,
    id_user integer,
    id_ml_request integer,
    view_date date
);


ALTER TABLE public.ml_request_history OWNER TO "user";

--
-- Name: ml_request_history_id_ml_history_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.ml_request_history_id_ml_history_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ml_request_history_id_ml_history_seq OWNER TO "user";

--
-- Name: ml_request_history_id_ml_history_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user
--

ALTER SEQUENCE public.ml_request_history_id_ml_history_seq OWNED BY public.ml_request_history.id_ml_history;


--
-- Name: ml_request_id_ml_request_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.ml_request_id_ml_request_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ml_request_id_ml_request_seq OWNER TO "user";

--
-- Name: ml_request_id_ml_request_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user
--

ALTER SEQUENCE public.ml_request_id_ml_request_seq OWNED BY public.ml_request.id_ml_request;


--
-- Name: places; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.places (
    id_place integer NOT NULL,
    id_city integer,
    photo_place character varying(255) DEFAULT NULL::character varying,
    name_place character varying(1000) NOT NULL,
    url_place character varying(1000) DEFAULT NULL::character varying,
    favorites_count integer NOT NULL,
    desc_place character varying(255) DEFAULT NULL::character varying
);


ALTER TABLE public.places OWNER TO "user";

--
-- Name: places_id_place_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.places_id_place_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.places_id_place_seq OWNER TO "user";

--
-- Name: places_id_place_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user
--

ALTER SEQUENCE public.places_id_place_seq OWNED BY public.places.id_place;


--
-- Name: request_history; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.request_history (
    id_request_history integer NOT NULL,
    id_user integer,
    id_flight integer,
    view_date date
);


ALTER TABLE public.request_history OWNER TO "user";

--
-- Name: request_history_id_request_history_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.request_history_id_request_history_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.request_history_id_request_history_seq OWNER TO "user";

--
-- Name: request_history_id_request_history_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user
--

ALTER SEQUENCE public.request_history_id_request_history_seq OWNED BY public.request_history.id_request_history;


--
-- Name: users; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.users (
    id integer NOT NULL,
    email character varying(180) NOT NULL,
    roles json NOT NULL,
    password character varying(255) NOT NULL,
    uuid uuid NOT NULL
);


ALTER TABLE public.users OWNER TO "user";

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO "user";

--
-- Name: city id_city; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.city ALTER COLUMN id_city SET DEFAULT nextval('public.city_id_city_seq'::regclass);


--
-- Name: favorites id_favorites; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.favorites ALTER COLUMN id_favorites SET DEFAULT nextval('public.favorites_id_favorites_seq'::regclass);


--
-- Name: flight id_flight; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.flight ALTER COLUMN id_flight SET DEFAULT nextval('public.flight_id_flight_seq'::regclass);


--
-- Name: ml_request id_ml_request; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.ml_request ALTER COLUMN id_ml_request SET DEFAULT nextval('public.ml_request_id_ml_request_seq'::regclass);


--
-- Name: ml_request_history id_ml_history; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.ml_request_history ALTER COLUMN id_ml_history SET DEFAULT nextval('public.ml_request_history_id_ml_history_seq'::regclass);


--
-- Name: places id_place; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.places ALTER COLUMN id_place SET DEFAULT nextval('public.places_id_place_seq'::regclass);


--
-- Name: request_history id_request_history; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.request_history ALTER COLUMN id_request_history SET DEFAULT nextval('public.request_history_id_request_history_seq'::regclass);


--
-- Data for Name: city; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.city (id_city, name_city, amount_views_city, photo_city, desc_city) FROM stdin;
\.


--
-- Data for Name: doctrine_migration_versions; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.doctrine_migration_versions (version, executed_at, execution_time) FROM stdin;
DoctrineMigrations\\Version20240711144001	2024-07-11 16:00:07	9
DoctrineMigrations\\Version20240711155955	2024-07-11 16:00:07	186
DoctrineMigrations\\Version20240712131454	2024-07-12 18:01:27	630
DoctrineMigrations\\Version20240712180118	2024-07-12 18:01:46	33
\.


--
-- Data for Name: favorites; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.favorites (id_favorites, id_place, id_user) FROM stdin;
\.


--
-- Data for Name: flight; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.flight (id_flight, id_user, id_city, from_flight, date_dep_flight, airline_flight, time_taken_flight, price, amount_stops, date_arr_flight, econom_class) FROM stdin;
\.


--
-- Data for Name: ml_request; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.ml_request (id_ml_request, id_user, id_city, price_request, class_request, position_request, amount_stops_request, date_arr_request, date_dep_request) FROM stdin;
\.


--
-- Data for Name: ml_request_history; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.ml_request_history (id_ml_history, id_user, id_ml_request, view_date) FROM stdin;
\.


--
-- Data for Name: places; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.places (id_place, id_city, photo_place, name_place, url_place, favorites_count, desc_place) FROM stdin;
\.


--
-- Data for Name: request_history; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.request_history (id_request_history, id_user, id_flight, view_date) FROM stdin;
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.users (id, email, roles, password, uuid) FROM stdin;
8	maxil@mail.ru	[]	$2y$13$nTeD.UDI91OAXIpjg5TRhOxGOjWo1/qIiNzRD8D/BZQhcdfTF1GAa	72086036-9ea7-4257-a1bf-bb21898e1627
10	yaz678@bk.ru	[]	$2y$13$6htN.HeaFd4Bh7M.uvE4m.pDylayv460ag/T265SWU8xUCUjtTcaq	134325a5-8090-4542-bd82-b4539f05f409
11	maximka@mail.ru	[]	$2y$13$64cb.I0s7NvPY2o2S8zquuFdpyvNZHZT5uqUHghPszVRQ3w7dYqNm	c91f46da-1078-43be-a2cc-4be2f50e4db6
12	ivanov@example.com	[]	$2y$13$6arn.JXyBYs9jf8qkYXGaOHZTttcR/pLTGyzJJHCFNHyCeIm64XQK	409c5791-e98b-4c8c-a8f6-fd1fe7bb9f15
\.


--
-- Name: city_id_city_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.city_id_city_seq', 1, false);


--
-- Name: favorites_id_favorites_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.favorites_id_favorites_seq', 1, false);


--
-- Name: flight_id_flight_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.flight_id_flight_seq', 1, false);


--
-- Name: ml_request_history_id_ml_history_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.ml_request_history_id_ml_history_seq', 1, false);


--
-- Name: ml_request_id_ml_request_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.ml_request_id_ml_request_seq', 1, false);


--
-- Name: places_id_place_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.places_id_place_seq', 1, false);


--
-- Name: request_history_id_request_history_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.request_history_id_request_history_seq', 1, false);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.users_id_seq', 12, true);


--
-- Name: city city_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.city
    ADD CONSTRAINT city_pkey PRIMARY KEY (id_city);


--
-- Name: doctrine_migration_versions doctrine_migration_versions_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.doctrine_migration_versions
    ADD CONSTRAINT doctrine_migration_versions_pkey PRIMARY KEY (version);


--
-- Name: favorites favorites_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.favorites
    ADD CONSTRAINT favorites_pkey PRIMARY KEY (id_favorites);


--
-- Name: flight flight_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.flight
    ADD CONSTRAINT flight_pkey PRIMARY KEY (id_flight);


--
-- Name: ml_request_history ml_request_history_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.ml_request_history
    ADD CONSTRAINT ml_request_history_pkey PRIMARY KEY (id_ml_history);


--
-- Name: ml_request ml_request_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.ml_request
    ADD CONSTRAINT ml_request_pkey PRIMARY KEY (id_ml_request);


--
-- Name: places places_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.places
    ADD CONSTRAINT places_pkey PRIMARY KEY (id_place);


--
-- Name: request_history request_history_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.request_history
    ADD CONSTRAINT request_history_pkey PRIMARY KEY (id_request_history);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: also_has_fk; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX also_has_fk ON public.flight USING btree (id_user);


--
-- Name: are_included_fk; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX are_included_fk ON public.favorites USING btree (id_place);


--
-- Name: favorites_pk; Type: INDEX; Schema: public; Owner: user
--

CREATE UNIQUE INDEX favorites_pk ON public.favorites USING btree (id_favorites);


--
-- Name: flight_pk; Type: INDEX; Schema: public; Owner: user
--

CREATE UNIQUE INDEX flight_pk ON public.flight USING btree (id_flight);


--
-- Name: has_fk; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX has_fk ON public.request_history USING btree (id_user);


--
-- Name: have_fk; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX have_fk ON public.favorites USING btree (id_user);


--
-- Name: idx_5739248d6b3ca4b; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX idx_5739248d6b3ca4b ON public.ml_request USING btree (id_user);


--
-- Name: idx_5739248da67b1e36; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX idx_5739248da67b1e36 ON public.ml_request USING btree (id_city);


--
-- Name: idx_978590c6b3ca4b; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX idx_978590c6b3ca4b ON public.ml_request_history USING btree (id_user);


--
-- Name: idx_978590cf2b3a45a; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX idx_978590cf2b3a45a ON public.ml_request_history USING btree (id_ml_request);


--
-- Name: idx_c257e60ea67b1e36; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX idx_c257e60ea67b1e36 ON public.flight USING btree (id_city);


--
-- Name: idx_feaf6c55a67b1e36; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX idx_feaf6c55a67b1e36 ON public.places USING btree (id_city);


--
-- Name: include_fk; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX include_fk ON public.request_history USING btree (id_flight);


--
-- Name: places_pk; Type: INDEX; Schema: public; Owner: user
--

CREATE UNIQUE INDEX places_pk ON public.places USING btree (id_place);


--
-- Name: request_history_pk; Type: INDEX; Schema: public; Owner: user
--

CREATE UNIQUE INDEX request_history_pk ON public.request_history USING btree (id_request_history);


--
-- Name: uniq_1483a5e9e7927c74; Type: INDEX; Schema: public; Owner: user
--

CREATE UNIQUE INDEX uniq_1483a5e9e7927c74 ON public.users USING btree (email);


--
-- PostgreSQL database dump complete
--

