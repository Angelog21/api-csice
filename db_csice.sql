PGDMP     .    6    
            z            csice    13.6    13.6 X    .           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            /           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            0           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            1           1262    16394    csice    DATABASE     e   CREATE DATABASE csice WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'Spanish_Venezuela.1252';
    DROP DATABASE csice;
                postgres    false            ?            1259    16439    failed_jobs    TABLE     &  CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);
    DROP TABLE public.failed_jobs;
       public         heap    postgres    false            ?            1259    16437    failed_jobs_id_seq    SEQUENCE     {   CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.failed_jobs_id_seq;
       public          postgres    false    208            2           0    0    failed_jobs_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;
          public          postgres    false    207            ?            1259    16397 
   migrations    TABLE     ?   CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);
    DROP TABLE public.migrations;
       public         heap    postgres    false            ?            1259    16395    migrations_id_seq    SEQUENCE     ?   CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.migrations_id_seq;
       public          postgres    false    201            3           0    0    migrations_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;
          public          postgres    false    200            ?            1259    16430    password_resets    TABLE     ?   CREATE TABLE public.password_resets (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);
 #   DROP TABLE public.password_resets;
       public         heap    postgres    false            ?            1259    16532    payment_files    TABLE     #  CREATE TABLE public.payment_files (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    service_requests_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    url text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 !   DROP TABLE public.payment_files;
       public         heap    postgres    false            ?            1259    16530    payment_files_id_seq    SEQUENCE     }   CREATE SEQUENCE public.payment_files_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.payment_files_id_seq;
       public          postgres    false    220            4           0    0    payment_files_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.payment_files_id_seq OWNED BY public.payment_files.id;
          public          postgres    false    219            ?            1259    16453    personal_access_tokens    TABLE     ?  CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 *   DROP TABLE public.personal_access_tokens;
       public         heap    postgres    false            ?            1259    16451    personal_access_tokens_id_seq    SEQUENCE     ?   CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 4   DROP SEQUENCE public.personal_access_tokens_id_seq;
       public          postgres    false    210            5           0    0    personal_access_tokens_id_seq    SEQUENCE OWNED BY     _   ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;
          public          postgres    false    209            ?            1259    16405    roles    TABLE     ?   CREATE TABLE public.roles (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.roles;
       public         heap    postgres    false            ?            1259    16403    roles_id_seq    SEQUENCE     u   CREATE SEQUENCE public.roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.roles_id_seq;
       public          postgres    false    203            6           0    0    roles_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;
          public          postgres    false    202            ?            1259    16478    service_requests    TABLE     ?  CREATE TABLE public.service_requests (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    service_id bigint NOT NULL,
    price double precision NOT NULL,
    iva double precision NOT NULL,
    total double precision NOT NULL,
    quantity integer NOT NULL,
    status character varying(255) DEFAULT 'Creado'::character varying NOT NULL,
    observation text,
    start_date date,
    end_date date,
    expiration_date timestamp(0) without time zone,
    responsed_at timestamp(0) without time zone,
    completed_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 $   DROP TABLE public.service_requests;
       public         heap    postgres    false            ?            1259    16476    service_requests_id_seq    SEQUENCE     ?   CREATE SEQUENCE public.service_requests_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.service_requests_id_seq;
       public          postgres    false    214            7           0    0    service_requests_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.service_requests_id_seq OWNED BY public.service_requests.id;
          public          postgres    false    213            ?            1259    16467    services    TABLE     l  CREATE TABLE public.services (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    unit character varying(255) NOT NULL,
    code character varying(255) NOT NULL,
    iva_value double precision NOT NULL,
    petro_quantity double precision NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.services;
       public         heap    postgres    false            ?            1259    16465    services_id_seq    SEQUENCE     x   CREATE SEQUENCE public.services_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.services_id_seq;
       public          postgres    false    212            8           0    0    services_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.services_id_seq OWNED BY public.services.id;
          public          postgres    false    211            ?            1259    16516 
   user_files    TABLE     !  CREATE TABLE public.user_files (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    type character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    url text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.user_files;
       public         heap    postgres    false            ?            1259    16514    user_files_id_seq    SEQUENCE     z   CREATE SEQUENCE public.user_files_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.user_files_id_seq;
       public          postgres    false    218            9           0    0    user_files_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.user_files_id_seq OWNED BY public.user_files.id;
          public          postgres    false    217            ?            1259    16500 	   user_logs    TABLE     ?   CREATE TABLE public.user_logs (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    type character varying(255) NOT NULL,
    data text NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.user_logs;
       public         heap    postgres    false            ?            1259    16498    user_logs_id_seq    SEQUENCE     y   CREATE SEQUENCE public.user_logs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.user_logs_id_seq;
       public          postgres    false    216            :           0    0    user_logs_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.user_logs_id_seq OWNED BY public.user_logs.id;
          public          postgres    false    215            ?            1259    16413    users    TABLE     ?  CREATE TABLE public.users (
    id bigint NOT NULL,
    role_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    phone character varying(255) NOT NULL,
    rif character varying(255) NOT NULL,
    social_reason character varying(255) NOT NULL,
    direction character varying(255) NOT NULL,
    confirmation_code character varying(255),
    last_connection timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.users;
       public         heap    postgres    false            ?            1259    16411    users_id_seq    SEQUENCE     u   CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.users_id_seq;
       public          postgres    false    205            ;           0    0    users_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;
          public          postgres    false    204            i           2604    16442    failed_jobs id    DEFAULT     p   ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);
 =   ALTER TABLE public.failed_jobs ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    207    208    208            e           2604    16400    migrations id    DEFAULT     n   ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);
 <   ALTER TABLE public.migrations ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    201    200    201            q           2604    16535    payment_files id    DEFAULT     t   ALTER TABLE ONLY public.payment_files ALTER COLUMN id SET DEFAULT nextval('public.payment_files_id_seq'::regclass);
 ?   ALTER TABLE public.payment_files ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    220    219    220            k           2604    16456    personal_access_tokens id    DEFAULT     ?   ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);
 H   ALTER TABLE public.personal_access_tokens ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    210    209    210            f           2604    16408    roles id    DEFAULT     d   ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);
 7   ALTER TABLE public.roles ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    202    203    203            m           2604    16481    service_requests id    DEFAULT     z   ALTER TABLE ONLY public.service_requests ALTER COLUMN id SET DEFAULT nextval('public.service_requests_id_seq'::regclass);
 B   ALTER TABLE public.service_requests ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    213    214    214            l           2604    16470    services id    DEFAULT     j   ALTER TABLE ONLY public.services ALTER COLUMN id SET DEFAULT nextval('public.services_id_seq'::regclass);
 :   ALTER TABLE public.services ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    212    211    212            p           2604    16519    user_files id    DEFAULT     n   ALTER TABLE ONLY public.user_files ALTER COLUMN id SET DEFAULT nextval('public.user_files_id_seq'::regclass);
 <   ALTER TABLE public.user_files ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    218    217    218            o           2604    16503    user_logs id    DEFAULT     l   ALTER TABLE ONLY public.user_logs ALTER COLUMN id SET DEFAULT nextval('public.user_logs_id_seq'::regclass);
 ;   ALTER TABLE public.user_logs ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    215    216    216            g           2604    16416    users id    DEFAULT     d   ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);
 7   ALTER TABLE public.users ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    204    205    205                      0    16439    failed_jobs 
   TABLE DATA           a   COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
    public          postgres    false    208   wm                 0    16397 
   migrations 
   TABLE DATA           :   COPY public.migrations (id, migration, batch) FROM stdin;
    public          postgres    false    201   ?m                 0    16430    password_resets 
   TABLE DATA           C   COPY public.password_resets (email, token, created_at) FROM stdin;
    public          postgres    false    206   wn       +          0    16532    payment_files 
   TABLE DATA           l   COPY public.payment_files (id, user_id, service_requests_id, name, url, created_at, updated_at) FROM stdin;
    public          postgres    false    220   ?n       !          0    16453    personal_access_tokens 
   TABLE DATA           ?   COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, created_at, updated_at) FROM stdin;
    public          postgres    false    210   ?n                 0    16405    roles 
   TABLE DATA           A   COPY public.roles (id, name, created_at, updated_at) FROM stdin;
    public          postgres    false    203   ?n       %          0    16478    service_requests 
   TABLE DATA           ?   COPY public.service_requests (id, user_id, service_id, price, iva, total, quantity, status, observation, start_date, end_date, expiration_date, responsed_at, completed_at, created_at, updated_at) FROM stdin;
    public          postgres    false    214   Ko       #          0    16467    services 
   TABLE DATA           k   COPY public.services (id, name, unit, code, iva_value, petro_quantity, created_at, updated_at) FROM stdin;
    public          postgres    false    212   ho       )          0    16516 
   user_files 
   TABLE DATA           Z   COPY public.user_files (id, user_id, type, name, url, created_at, updated_at) FROM stdin;
    public          postgres    false    218   ?o       '          0    16500 	   user_logs 
   TABLE DATA           T   COPY public.user_logs (id, user_id, type, data, created_at, updated_at) FROM stdin;
    public          postgres    false    216   ?o                 0    16413    users 
   TABLE DATA           ?   COPY public.users (id, role_id, name, email, phone, rif, social_reason, direction, confirmation_code, last_connection, password, email_verified_at, active, created_at, updated_at) FROM stdin;
    public          postgres    false    205   
p       <           0    0    failed_jobs_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);
          public          postgres    false    207            =           0    0    migrations_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.migrations_id_seq', 10, true);
          public          postgres    false    200            >           0    0    payment_files_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.payment_files_id_seq', 1, true);
          public          postgres    false    219            ?           0    0    personal_access_tokens_id_seq    SEQUENCE SET     L   SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 1, false);
          public          postgres    false    209            @           0    0    roles_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.roles_id_seq', 1, false);
          public          postgres    false    202            A           0    0    service_requests_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.service_requests_id_seq', 2, true);
          public          postgres    false    213            B           0    0    services_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.services_id_seq', 1, true);
          public          postgres    false    211            C           0    0    user_files_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.user_files_id_seq', 2, true);
          public          postgres    false    217            D           0    0    user_logs_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.user_logs_id_seq', 1, false);
          public          postgres    false    215            E           0    0    users_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.users_id_seq', 1, false);
          public          postgres    false    204            |           2606    16448    failed_jobs failed_jobs_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.failed_jobs DROP CONSTRAINT failed_jobs_pkey;
       public            postgres    false    208            ~           2606    16450 #   failed_jobs failed_jobs_uuid_unique 
   CONSTRAINT     ^   ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);
 M   ALTER TABLE ONLY public.failed_jobs DROP CONSTRAINT failed_jobs_uuid_unique;
       public            postgres    false    208            s           2606    16402    migrations migrations_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.migrations DROP CONSTRAINT migrations_pkey;
       public            postgres    false    201            ?           2606    16540     payment_files payment_files_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.payment_files
    ADD CONSTRAINT payment_files_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.payment_files DROP CONSTRAINT payment_files_pkey;
       public            postgres    false    220            ?           2606    16461 2   personal_access_tokens personal_access_tokens_pkey 
   CONSTRAINT     p   ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);
 \   ALTER TABLE ONLY public.personal_access_tokens DROP CONSTRAINT personal_access_tokens_pkey;
       public            postgres    false    210            ?           2606    16464 :   personal_access_tokens personal_access_tokens_token_unique 
   CONSTRAINT     v   ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);
 d   ALTER TABLE ONLY public.personal_access_tokens DROP CONSTRAINT personal_access_tokens_token_unique;
       public            postgres    false    210            u           2606    16410    roles roles_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.roles DROP CONSTRAINT roles_pkey;
       public            postgres    false    203            ?           2606    16487 &   service_requests service_requests_pkey 
   CONSTRAINT     d   ALTER TABLE ONLY public.service_requests
    ADD CONSTRAINT service_requests_pkey PRIMARY KEY (id);
 P   ALTER TABLE ONLY public.service_requests DROP CONSTRAINT service_requests_pkey;
       public            postgres    false    214            ?           2606    16475    services services_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.services
    ADD CONSTRAINT services_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.services DROP CONSTRAINT services_pkey;
       public            postgres    false    212            ?           2606    16524    user_files user_files_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.user_files
    ADD CONSTRAINT user_files_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.user_files DROP CONSTRAINT user_files_pkey;
       public            postgres    false    218            ?           2606    16508    user_logs user_logs_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.user_logs
    ADD CONSTRAINT user_logs_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.user_logs DROP CONSTRAINT user_logs_pkey;
       public            postgres    false    216            w           2606    16429    users users_email_unique 
   CONSTRAINT     T   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);
 B   ALTER TABLE ONLY public.users DROP CONSTRAINT users_email_unique;
       public            postgres    false    205            y           2606    16422    users users_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.users DROP CONSTRAINT users_pkey;
       public            postgres    false    205            z           1259    16436    password_resets_email_index    INDEX     X   CREATE INDEX password_resets_email_index ON public.password_resets USING btree (email);
 /   DROP INDEX public.password_resets_email_index;
       public            postgres    false    206            ?           1259    16462 8   personal_access_tokens_tokenable_type_tokenable_id_index    INDEX     ?   CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);
 L   DROP INDEX public.personal_access_tokens_tokenable_type_tokenable_id_index;
       public            postgres    false    210    210            ?           2606    16546 7   payment_files payment_files_service_requests_id_foreign    FK CONSTRAINT     ?   ALTER TABLE ONLY public.payment_files
    ADD CONSTRAINT payment_files_service_requests_id_foreign FOREIGN KEY (service_requests_id) REFERENCES public.service_requests(id);
 a   ALTER TABLE ONLY public.payment_files DROP CONSTRAINT payment_files_service_requests_id_foreign;
       public          postgres    false    214    220    2951            ?           2606    16541 +   payment_files payment_files_user_id_foreign    FK CONSTRAINT     ?   ALTER TABLE ONLY public.payment_files
    ADD CONSTRAINT payment_files_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);
 U   ALTER TABLE ONLY public.payment_files DROP CONSTRAINT payment_files_user_id_foreign;
       public          postgres    false    205    220    2937            ?           2606    16493 4   service_requests service_requests_service_id_foreign    FK CONSTRAINT     ?   ALTER TABLE ONLY public.service_requests
    ADD CONSTRAINT service_requests_service_id_foreign FOREIGN KEY (service_id) REFERENCES public.services(id);
 ^   ALTER TABLE ONLY public.service_requests DROP CONSTRAINT service_requests_service_id_foreign;
       public          postgres    false    214    212    2949            ?           2606    16488 1   service_requests service_requests_user_id_foreign    FK CONSTRAINT     ?   ALTER TABLE ONLY public.service_requests
    ADD CONSTRAINT service_requests_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);
 [   ALTER TABLE ONLY public.service_requests DROP CONSTRAINT service_requests_user_id_foreign;
       public          postgres    false    214    205    2937            ?           2606    16525 %   user_files user_files_user_id_foreign    FK CONSTRAINT     ?   ALTER TABLE ONLY public.user_files
    ADD CONSTRAINT user_files_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);
 O   ALTER TABLE ONLY public.user_files DROP CONSTRAINT user_files_user_id_foreign;
       public          postgres    false    205    2937    218            ?           2606    16509 #   user_logs user_logs_user_id_foreign    FK CONSTRAINT     ?   ALTER TABLE ONLY public.user_logs
    ADD CONSTRAINT user_logs_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);
 M   ALTER TABLE ONLY public.user_logs DROP CONSTRAINT user_logs_user_id_foreign;
       public          postgres    false    205    2937    216            ?           2606    16423    users users_role_id_foreign    FK CONSTRAINT     z   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id);
 E   ALTER TABLE ONLY public.users DROP CONSTRAINT users_role_id_foreign;
       public          postgres    false    205    203    2933                  x?????? ? ?         ?   x?]???? @??c?$?m?g2?Ɲ?X???P?-N?^pG??A1CM?;/f??J?ɜ?찢֌?H??A|U	?
??^???%Ȕ?:)???t???????N?|?4?????B???e?u??.2f?+??Em?????9tEp?ei?ƌ?CB?.NÔ?D5??غ????m| 4V?y(????z???U?ڼ?2N㸯???J            x?????? ? ?      +      x?????? ? ?      !      x?????? ? ?         m   x?3?(J-?LI?+I?4202?50?52T02?!,b?\F?.?E??%?E??FV&Z??L???9?s2?K?h?Ģň˄?9'????X-1???/!R?!W? w?6       %      x?????? ? ?      #   X   x?3?t?,?MTp?IM.):?9/39??9??$3?J??p:r??q?r??Z(?YX????[ Ō?b???? m?n      )      x?????? ? ?      '      x?????? ? ?         W  x?e?MR?@?דSd??8??2+?VPA,6c!?̔ ?N?(-?????~??P??B??????J??/?_.2??^l3?a(?@и~???]????;?m?\??ۭQ?;׮2y?)cъ5y"?"?Sgbm??~??8m?l??l?G?;T??Fpm?̺~4???2???:?Dyyш?޾???fe?F?z??@??Ա_???*\~ނ??d?????q?Ar?DPh:????!A?_?W5???????Ke????X?U\yUhg???_'??	?A?Iy/????[?N???Fɲˡ'??-?d-?+??~e??d?????}]:3?q?O???S     