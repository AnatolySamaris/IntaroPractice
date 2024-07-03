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
    name_city character varying(100),
    amount_views_city integer,
    photo_city character varying,
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
    from_flight character varying(70),
    date_dep_flight timestamp without time zone,
    airline_flight character varying(70),
    time_taken_flight character varying(100),
    price integer,
    amount_stops integer,
    date_arr_flight timestamp without time zone,
    id_city integer,
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
    price_request numeric,
    class_request character varying(255),
    position_request character varying(255),
    amount_stops_request integer,
    date_arr_request timestamp without time zone,
    date_dep_request timestamp without time zone,
    id_user integer,
    id_city integer
);


ALTER TABLE public.ml_request OWNER TO "user";

--
-- Name: ml_request_history; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.ml_request_history (
    id_user integer,
    id_ml_request integer,
    view_date date,
    id_ml_history integer NOT NULL
);


ALTER TABLE public.ml_request_history OWNER TO "user";

--
-- Name: ml_request_history_id_ml_history_new_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.ml_request_history_id_ml_history_new_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ml_request_history_id_ml_history_new_seq OWNER TO "user";

--
-- Name: ml_request_history_id_ml_history_new_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user
--

ALTER SEQUENCE public.ml_request_history_id_ml_history_new_seq OWNED BY public.ml_request_history.id_ml_history;


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
    photo_place character varying(255),
    name_place character varying(1000) NOT NULL,
    url_place character varying(1000),
    favorites_count integer NOT NULL,
    id_city integer,
    desc_place character varying
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
    id_user integer NOT NULL,
    full_name_user character varying(100) NOT NULL,
    email_user character varying(100) NOT NULL,
    password_user character varying(255) NOT NULL,
    role_user character varying(100) NOT NULL,
    photo_user character varying(100),
    news_mailing boolean NOT NULL,
    phone_user character varying(20),
    birth_user date,
    date_mail date
);


ALTER TABLE public.users OWNER TO "user";

--
-- Name: users_id_user_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.users_id_user_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_user_seq OWNER TO "user";

--
-- Name: users_id_user_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: user
--

ALTER SEQUENCE public.users_id_user_seq OWNED BY public.users.id_user;


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

ALTER TABLE ONLY public.ml_request_history ALTER COLUMN id_ml_history SET DEFAULT nextval('public.ml_request_history_id_ml_history_new_seq'::regclass);


--
-- Name: places id_place; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.places ALTER COLUMN id_place SET DEFAULT nextval('public.places_id_place_seq'::regclass);


--
-- Name: request_history id_request_history; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.request_history ALTER COLUMN id_request_history SET DEFAULT nextval('public.request_history_id_request_history_seq'::regclass);


--
-- Name: users id_user; Type: DEFAULT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.users ALTER COLUMN id_user SET DEFAULT nextval('public.users_id_user_seq'::regclass);


--
-- Data for Name: city; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.city (id_city, name_city, amount_views_city, photo_city, desc_city) FROM stdin;
26	Мумбаи	130	/mumba.jpg	Мумбаи, финансовая столица Индии, известен своими небоскрёбами, Болливудом и оживленным уличным рынком.
22	Ченнаи	90	/chen.jpg	Ченнаи, крупный город на юго-востоке Индии, славится своими храмами, пляжами и богатым культурным наследием.
23	Дели	100	/deli.jpg	Дели, столица Индии, сочетает в себе древние памятники и современные архитектурные шедевры, а также является политическим центром страны.
24	Хайдарабад	110	hai.jpg	Хайдарабад, город с богатой историей, известен своими IT-индустриями и знаменитыми бирьяни.
25	Калькутта	120	/kaljut.jpg	Калькутта, культурная столица Индии, славится своей литературной и художественной средой, а также архитектурой колониального периода.
21	Бангалор	81	/bango.jpg	Бангалор, известный как "Силиконовая долина Индии", является крупным IT-центром с множеством технологических компаний и стартапов.
\.


--
-- Data for Name: favorites; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.favorites (id_favorites, id_place, id_user) FROM stdin;
13	8	2
14	9	2
15	15	3
16	14	2
17	18	2
19	13	2
\.


--
-- Data for Name: flight; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.flight (id_flight, id_user, from_flight, date_dep_flight, airline_flight, time_taken_flight, price, amount_stops, date_arr_flight, id_city, econom_class) FROM stdin;
\.


--
-- Data for Name: ml_request; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.ml_request (id_ml_request, price_request, class_request, position_request, amount_stops_request, date_arr_request, date_dep_request, id_user, id_city) FROM stdin;
1	1500	Zero	Moscow	1	2024-06-01 00:00:00	2024-05-31 00:00:00	2	\N
2	1500	Zero	Moscow	1	2024-06-01 00:00:00	2024-05-31 00:00:00	2	21
3	1500	Zero	Moscow	1	2024-06-01 00:00:00	2024-05-31 00:00:00	2	21
\.


--
-- Data for Name: ml_request_history; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.ml_request_history (id_user, id_ml_request, view_date, id_ml_history) FROM stdin;
2	1	2024-06-01	1
3	1	2024-06-01	2
2	1	2024-06-01	3
3	1	2024-06-02	36
\.


--
-- Data for Name: places; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.places (id_place, photo_place, name_place, url_place, favorites_count, id_city, desc_place) FROM stdin;
1	/garden_bangalore.jpg	Ботанический сад Лалбагх	https://example.com/lalbagh	5	21	Красивый ботанический сад в Бангалоре.
2	/temple_mumbai.jpg	Храм Шри Сиддхивинаяк	https://example.com/siddhivinayak	6	26	Знаменитый индуистский храм в Мумбаи.
3	/beach_chennai.jpg	Пляж Марина	https://example.com/marina_beach	20	22	Самый длинный пляж в Ченнаи.
4	/tomb_delhi.jpg	Гробница Хумаюна	https://example.com/humayuns_tomb	30	23	Историческая гробница в Дели.
5	/fort_hyderabad.jpg	Форт Голконда	https://example.com/golconda	43	24	Древний форт в Хайдарабаде.
6	/memorial_kolkata.jpg	Виктория Мемориал	https://example.com/victoria_memorial	11	25	Великолепное мраморное строение в Калькутте.
7	/palace_bangalore.jpg	Дворец Бангалора	https://example.com/bangalore_palace	22	21	Великолепный дворец в Бангалоре.
8	/gateway_mumbai.jpg	Ворота Индии	https://example.com/gateway_of_india	66	26	Знаковый памятник в Мумбаи.
9	/fort_chennai.jpg	Форт Сент-Джордж	https://example.com/fort_st_george	12	22	Исторический форт в Ченнаи.
10	/qutub_delhi.jpg	Кутб-Минар	https://example.com/qutub_minar	16	23	Иконический минарет в Дели.
11	/charminar_hyderabad.jpg	Чарминар	https://example.com/charminar	15	24	Знаменитая мечеть в Хайдарабаде.
12	/bridge_kolkata.jpg	Мост Хаура	https://example.com/howrah_bridge	21	25	Знаменитый мост в Калькутте.
14	/cave_mumbai.jpg	Пещеры Элефанта	https://example.com/elephanta_caves	23	26	Древние пещеры на острове близ Мумбаи.
15	/temple_chennai.jpg	Храм Капалешварар	https://example.com/kapaleeshwarar_temple	25	22	Величественный храм в Ченнаи.
16	/temple_delhi.jpg	Храм Лотоса	https://example.com/lotus_temple	29	23	Современный храм в форме лотоса в Дели.
17	/museum_hyderabad.jpg	Салар Джунг Музей	https://example.com/salar_jung_museum	31	24	Известный музей в Хайдарабаде.
18	/park_kolkata.jpg	Парк Миллениум	https://example.com/millennium_park	23	25	Красивый парк на набережной Калькутты.
13	/temple_bangalore.jpg	Храм Булл	https://example.com/bull_temple	88	21	Известный храм в Бангалоре, посвященный быку Нанди.
\.


--
-- Data for Name: request_history; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.request_history (id_request_history, id_user, id_flight, view_date) FROM stdin;
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.users (id_user, full_name_user, email_user, password_user, role_user, photo_user, news_mailing, phone_user, birth_user, date_mail) FROM stdin;
10	Ольга Попова	olga@example.com	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	f	\N	\N	\N
11	Сергей Васильев	sergey@example.com	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	t	\N	\N	\N
12	Анна Соколова	anna@example.com	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	f	\N	\N	\N
13	Дмитрий Михайлов	dmitry@example.com	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	t	\N	\N	\N
14	Екатерина Новикова	ekaterina@example.com	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	f	\N	\N	\N
15	Дьяков Дмитрий Владимирович	example@bk.ru	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	f	\N	\N	\N
3	Кретов Игорь Олегович	knigor1337@gmail.com	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	t	\N	\N	2024-05-31
4	Толстунов Владимир Дмитриевич	r.vladimir.tolstunov@gmail.com	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	t	\N	\N	2024-05-31
5	Иван Иванов	ivan@example.com	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	t	\N	\N	\N
6	Мария Петрова	maria@example.com	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	f	\N	\N	\N
7	Александр Сидоров	alex@example.com	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	t	\N	\N	\N
8	Елена Смирнова	elena@example.com	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	f	\N	\N	\N
9	Андрей Кузнецов	andrey@example.com	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	user	/empty.svg	t	\N	\N	\N
2	НеБолдырев Максим Романович	maxrox1904@gmail.com	307fd56085a6ed891cfb2c38276d7853b122968754378f1153e0127f3a764a0f	user	/20240531194345.jpg	t	9802695322	1990-01-01	2024-05-31
\.


--
-- Name: city_id_city_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.city_id_city_seq', 26, true);


--
-- Name: favorites_id_favorites_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.favorites_id_favorites_seq', 19, true);


--
-- Name: flight_id_flight_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.flight_id_flight_seq', 24, true);


--
-- Name: ml_request_history_id_ml_history_new_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.ml_request_history_id_ml_history_new_seq', 36, true);


--
-- Name: ml_request_history_id_ml_history_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.ml_request_history_id_ml_history_seq', 1, false);


--
-- Name: ml_request_id_ml_request_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.ml_request_id_ml_request_seq', 3, true);


--
-- Name: places_id_place_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.places_id_place_seq', 24, true);


--
-- Name: request_history_id_request_history_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.request_history_id_request_history_seq', 11, true);


--
-- Name: users_id_user_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.users_id_user_seq', 15, true);


--
-- Name: city city_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.city
    ADD CONSTRAINT city_pkey PRIMARY KEY (id_city);


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
-- Name: favorites pk_favorites; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.favorites
    ADD CONSTRAINT pk_favorites PRIMARY KEY (id_favorites);


--
-- Name: flight pk_flight; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.flight
    ADD CONSTRAINT pk_flight PRIMARY KEY (id_flight);


--
-- Name: places pk_places; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.places
    ADD CONSTRAINT pk_places PRIMARY KEY (id_place);


--
-- Name: request_history pk_request_history; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.request_history
    ADD CONSTRAINT pk_request_history PRIMARY KEY (id_request_history);


--
-- Name: users pk_users; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT pk_users PRIMARY KEY (id_user);


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
-- Name: user_pk; Type: INDEX; Schema: public; Owner: user
--

CREATE UNIQUE INDEX user_pk ON public.users USING btree (id_user);


--
-- Name: ml_request fk_city; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.ml_request
    ADD CONSTRAINT fk_city FOREIGN KEY (id_city) REFERENCES public.city(id_city);


--
-- Name: favorites fk_favorite_are_inclu_places; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.favorites
    ADD CONSTRAINT fk_favorite_are_inclu_places FOREIGN KEY (id_place) REFERENCES public.places(id_place) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: favorites fk_favorite_have_users; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.favorites
    ADD CONSTRAINT fk_favorite_have_users FOREIGN KEY (id_user) REFERENCES public.users(id_user) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: flight fk_flight_also_has_users; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.flight
    ADD CONSTRAINT fk_flight_also_has_users FOREIGN KEY (id_user) REFERENCES public.users(id_user) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: ml_request_history fk_ml_request_history_ml_request; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.ml_request_history
    ADD CONSTRAINT fk_ml_request_history_ml_request FOREIGN KEY (id_ml_request) REFERENCES public.ml_request(id_ml_request) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: ml_request_history fk_ml_request_history_user; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.ml_request_history
    ADD CONSTRAINT fk_ml_request_history_user FOREIGN KEY (id_user) REFERENCES public.users(id_user) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: request_history fk_request__has_users; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.request_history
    ADD CONSTRAINT fk_request__has_users FOREIGN KEY (id_user) REFERENCES public.users(id_user) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: request_history fk_request__include_flight; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.request_history
    ADD CONSTRAINT fk_request__include_flight FOREIGN KEY (id_flight) REFERENCES public.flight(id_flight) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: flight flight_id_city_fkey; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.flight
    ADD CONSTRAINT flight_id_city_fkey FOREIGN KEY (id_city) REFERENCES public.city(id_city);


--
-- Name: ml_request ml_request_id_user_fkey; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.ml_request
    ADD CONSTRAINT ml_request_id_user_fkey FOREIGN KEY (id_user) REFERENCES public.users(id_user);


--
-- Name: places places_id_city_fkey; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.places
    ADD CONSTRAINT places_id_city_fkey FOREIGN KEY (id_city) REFERENCES public.city(id_city);


--
-- PostgreSQL database dump complete
--

