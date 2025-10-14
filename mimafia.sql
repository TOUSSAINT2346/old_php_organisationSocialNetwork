-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 14 okt 2025 kl 18:27
-- Serverversion: 10.4.32-MariaDB
-- PHP-version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `mimafia`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `badges`
--

CREATE TABLE `badges` (
  `id_ba` int(11) NOT NULL,
  `nsup_ba` int(11) NOT NULL,
  `ninf_ba` int(11) NOT NULL,
  `name_ba` varchar(255) NOT NULL,
  `img_ba` varchar(255) NOT NULL,
  `valueof_ba` varchar(50) NOT NULL,
  `value_ba` int(11) NOT NULL,
  `text_ba` text DEFAULT NULL,
  `next_ba` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `badges`
--

INSERT INTO `badges` (`id_ba`, `nsup_ba`, `ninf_ba`, `name_ba`, `img_ba`, `valueof_ba`, `value_ba`, `text_ba`, `next_ba`) VALUES
(1, 0, 0, 'Jornalista Nível I', '1-1', '10', 10, 'Por ter feito dez publicações.', 0),
(2, 0, 0, 'Festa', '2-1', '10', 10, 'Por participar de um evento.', 0),
(3, 0, 0, 'Usuário beta', '3', '100', 100, 'Por ter entrado na versão original do sistema.', 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `badge_won`
--

CREATE TABLE `badge_won` (
  `id_bw` int(11) NOT NULL,
  `idba_tot_bw` int(11) NOT NULL,
  `idba_bw` int(11) NOT NULL,
  `iduse_bw` int(11) NOT NULL,
  `date_bw` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur `capone_ger`
--

CREATE TABLE `capone_ger` (
  `id_capger` int(11) NOT NULL,
  `iduser_capger` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `capone_ger`
--

INSERT INTO `capone_ger` (`id_capger`, `iduser_capger`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Tabellstruktur `capone_reg`
--

CREATE TABLE `capone_reg` (
  `id_capreg` int(11) NOT NULL,
  `idcand_capreg` int(11) NOT NULL,
  `votos_capreg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `capone_reg`
--

INSERT INTO `capone_reg` (`id_capreg`, `idcand_capreg`, `votos_capreg`) VALUES
(3, 2, 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `comment`
--

CREATE TABLE `comment` (
  `id_com` int(11) NOT NULL,
  `creat_com` varchar(50) NOT NULL,
  `text_com` text NOT NULL,
  `tip_com` varchar(50) NOT NULL,
  `idpag_com` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `comment`
--

INSERT INTO `comment` (`id_com`, `creat_com`, `text_com`, `tip_com`, `idpag_com`) VALUES
(1, '2', 'This is a comment', 'event', 1),
(2, '2', 'This is the comment of a comment', 'event_com', 1),
(3, '2', 'New comment on project', 'project', 1),
(4, '2', 'Comment in post\r\n', 'post', 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `eleicao`
--

CREATE TABLE `eleicao` (
  `id_ele` int(11) NOT NULL,
  `dia_ele` int(2) NOT NULL,
  `mes_ele` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `eleicao`
--

INSERT INTO `eleicao` (`id_ele`, `dia_ele`, `mes_ele`) VALUES
(1, 1, 11);

-- --------------------------------------------------------

--
-- Tabellstruktur `events`
--

CREATE TABLE `events` (
  `id_event` int(11) NOT NULL,
  `tit_event` varchar(255) NOT NULL,
  `desc_event` text DEFAULT NULL,
  `data_event` varchar(200) NOT NULL,
  `creat_event` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `events`
--

INSERT INTO `events` (`id_event`, `tit_event`, `desc_event`, `data_event`, `creat_event`) VALUES
(1, 'New event', 'Cool event', '2025-10-30', '2'),
(2, 'Event in the future', NULL, '2025-12-31', '2');

-- --------------------------------------------------------

--
-- Tabellstruktur `liking`
--

CREATE TABLE `liking` (
  `id_lik` int(11) NOT NULL,
  `use_lik` int(11) NOT NULL,
  `post_lik` int(11) NOT NULL,
  `op_lik` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `liking`
--

INSERT INTO `liking` (`id_lik`, `use_lik`, `post_lik`, `op_lik`) VALUES
(2, 2, 3, 2);

-- --------------------------------------------------------

--
-- Tabellstruktur `matricula`
--

CREATE TABLE `matricula` (
  `id_mat` int(11) NOT NULL,
  `num_mat` int(20) NOT NULL,
  `use_mat` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `matricula`
--

INSERT INTO `matricula` (`id_mat`, `num_mat`, `use_mat`) VALUES
(1, 5689336, 1),
(2, 123155123, 0),
(3, 845632234, 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `notifs`
--

CREATE TABLE `notifs` (
  `id_not` int(11) NOT NULL,
  `iduse_not` int(11) NOT NULL,
  `msg_not` text NOT NULL,
  `link_not` varchar(200) NOT NULL,
  `date_not` varchar(20) NOT NULL,
  `hor_not` varchar(20) NOT NULL,
  `sit_not` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `notifs`
--

INSERT INTO `notifs` (`id_not`, `iduse_not`, `msg_not`, `link_not`, `date_not`, `hor_not`, `sit_not`) VALUES
(1, 2, '<font style=\"text-transform:capitalize;\">Caio</font> criou um novo evento!<br>Clica aqui para vê-lo!', 'eventsee.php?i=1', '14/10/2025', '10:33', 1),
(2, 2, '<font style=\"text-transform:capitalize;\">Caio</font> comentou teu artigo!<br>Clica aqui para lê-lo!', 'readpost.php?i=1', '2025-10-14', '13:58', 1),
(3, 2, 'Há plebiscito rolando!<br>Vota!', 'plebs.php', '14/10/2025', '15:46', 1),
(4, 2, 'Há plebiscito rolando!<br>Vota!', 'plebs.php', '14/10/2025', '15:47', 1),
(5, 2, 'Há plebiscito rolando!<br>Vota!', 'plebs.php', '14/10/2025', '15:48', 1),
(6, 2, 'Há plebiscito rolando!<br>Vota!', 'plebs.php', '14/10/2025', '15:51', 1),
(7, 2, 'Há plebiscito rolando!<br>Vota!', 'plebs.php', '14/10/2025', '15:52', 1),
(8, 2, 'Há plebiscito rolando!<br>Vota!', 'plebs.php', '14/10/2025', '15:53', 1),
(9, 2, 'Há plebiscito rolando!<br>Vota!', 'plebs.php', '14/10/2025', '15:54', 1),
(10, 2, 'Há plebiscito rolando!<br>Vota!', 'plebs.php', '14/10/2025', '15:55', 1),
(11, 2, 'Há plebiscito rolando!<br>Vota!', 'plebs.php', '14/10/2025', '15:56', 1),
(12, 2, 'Dia de Eleição! Já votaste?<br>Se não, clica aqui e vota!', 'capo.php', '2025-10-14', '17:18:02', 1),
(13, 2, '<font style=\"text-transform:capitalize;\">Creator</font> criou um novo evento!<br>Clica aqui para vê-lo!', 'eventsee.php?i=2', '14/10/2025', '18:15', 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `parola`
--

CREATE TABLE `parola` (
  `id_parola` int(11) NOT NULL,
  `text_parola` text NOT NULL,
  `creat_parola` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `parola`
--

INSERT INTO `parola` (`id_parola`, `text_parola`, `creat_parola`) VALUES
(1, 'Pronunciamento!', 2);

-- --------------------------------------------------------

--
-- Tabellstruktur `plebs`
--

CREATE TABLE `plebs` (
  `id_plebs` int(11) NOT NULL,
  `desc_plebs` text NOT NULL,
  `perg_plebs` text NOT NULL,
  `resp1_plebs` varchar(200) NOT NULL,
  `resp2_plebs` varchar(200) NOT NULL,
  `resp3_plebs` varchar(200) NOT NULL,
  `resp4_plebs` varchar(200) NOT NULL,
  `creat_plebs` varchar(20) NOT NULL,
  `date_plebs` varchar(200) NOT NULL,
  `datef_plebs` varchar(200) NOT NULL,
  `vis_plebs` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `plebs`
--

INSERT INTO `plebs` (`id_plebs`, `desc_plebs`, `perg_plebs`, `resp1_plebs`, `resp2_plebs`, `resp3_plebs`, `resp4_plebs`, `creat_plebs`, `date_plebs`, `datef_plebs`, `vis_plebs`) VALUES
(9, 'MUITO IMPORTANTE!', 'Plebiscito teste', 'Opção um', 'Opção dois', '', '', '2', '2025-10-14', '2025-10-16', 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `posts`
--

CREATE TABLE `posts` (
  `id_post` int(11) NOT NULL,
  `tit_post` varchar(200) NOT NULL,
  `text_post` text NOT NULL,
  `creat_post` varchar(200) NOT NULL,
  `date_post` varchar(20) NOT NULL,
  `totutil_post` varchar(200) NOT NULL,
  `cat_post` varchar(200) NOT NULL,
  `font_post` text NOT NULL,
  `vis_post` int(11) NOT NULL,
  `util_post` int(11) NOT NULL,
  `inutil_post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `posts`
--

INSERT INTO `posts` (`id_post`, `tit_post`, `text_post`, `creat_post`, `date_post`, `totutil_post`, `cat_post`, `font_post`, `vis_post`, `util_post`, `inutil_post`) VALUES
(1, 'Resultado do projeto N&deg; 1', '<p><b>Veredicto del Capo: Projeto <u>aprovado</u> pelo Capo Signore Caio Ponce de Leon Ribeiro Freire</b><br></p><br>\r\n    <p>O projeto de N&deg; 1 , criado por Caio Ponce de Leon Ribeiro Freire , em 2025-10-10 , submetido à aprovação del Capo em 2025-10-13 teve seu veredicto julgado como: <b>Projeto <u>aprovado</u>  </b></p><br><p>O projeto há-de efetivar-se o mais rápido possível</p>', '0', '2025-10-14', '', 'm', '', 22, 0, 0),
(2, 'Breaking News!!', 'It&#039;s breaking news!', '0', '2025-10-14', '0', 'nn', '', 1, 0, 0),
(3, 'Breaking News!!', 'asdas dasd asdas&amp;nbsp;', '2', '2025-10-14', '-1', 'ni', '', 10, 0, 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `projetos`
--

CREATE TABLE `projetos` (
  `id_proj` int(11) NOT NULL,
  `nome_proj` varchar(255) NOT NULL,
  `teor_proj` text DEFAULT NULL,
  `sit_proj` text NOT NULL,
  `dat_proj` varchar(200) NOT NULL,
  `datf_proj` varchar(200) NOT NULL,
  `creat_proj` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `projetos`
--

INSERT INTO `projetos` (`id_proj`, `nome_proj`, `teor_proj`, `sit_proj`, `dat_proj`, `datf_proj`, `creat_proj`) VALUES
(1, 'asdasdas', 'asdasd', 'Projeto <u>aprovado</u> pelo Capo Signore Creator', '2025-10-10', '2025-10-13', '2');

-- --------------------------------------------------------

--
-- Tabellstruktur `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nome_user` varchar(200) NOT NULL,
  `sobrenome_user` varchar(200) NOT NULL,
  `nickname_user` varchar(20) NOT NULL,
  `bday_user` varchar(20) NOT NULL,
  `turno_user` varchar(10) NOT NULL,
  `mail_user` varchar(200) NOT NULL,
  `sexo_user` varchar(20) NOT NULL,
  `pass_user` varchar(200) NOT NULL,
  `desc_user` text NOT NULL,
  `matricula_user` varchar(20) NOT NULL,
  `photo_user` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `user`
--

INSERT INTO `user` (`id_user`, `nome_user`, `sobrenome_user`, `nickname_user`, `bday_user`, `turno_user`, `mail_user`, `sexo_user`, `pass_user`, `desc_user`, `matricula_user`, `photo_user`) VALUES
(2, 'Creator', 'Of System', 'creator_system', '1997-09-11', 'm', 'creatorsystem@mimafia.camk.net', 'm', '$2y$10$4xQCUNlNr./UIZMjbxl.Eu8OZzMObfSqSbfHcsYri6HXhM2Wj.cd2', 'Criador do sistema', '5689336', '859277313.png');

-- --------------------------------------------------------

--
-- Tabellstruktur `votos`
--

CREATE TABLE `votos` (
  `id_voto` int(11) NOT NULL,
  `iduser_voto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `votos`
--

INSERT INTO `votos` (`id_voto`, `iduser_voto`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Tabellstruktur `votpleb`
--

CREATE TABLE `votpleb` (
  `id_vtp` int(11) NOT NULL,
  `idus_vtp` int(11) NOT NULL,
  `idple_vtp` int(11) NOT NULL,
  `resp_vtp` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `votpleb`
--

INSERT INTO `votpleb` (`id_vtp`, `idus_vtp`, `idple_vtp`, `resp_vtp`) VALUES
(1, 2, 9, '1');

-- --------------------------------------------------------

--
-- Tabellstruktur `vot_proj`
--

CREATE TABLE `vot_proj` (
  `id_vop` int(11) NOT NULL,
  `idproj_vop` int(11) NOT NULL,
  `iduser_vop` int(11) NOT NULL,
  `op_vop` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `vot_proj`
--

INSERT INTO `vot_proj` (`id_vop`, `idproj_vop`, `iduser_vop`, `op_vop`) VALUES
(1, 1, 2, '1');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `badges`
--
ALTER TABLE `badges`
  ADD PRIMARY KEY (`id_ba`);

--
-- Index för tabell `badge_won`
--
ALTER TABLE `badge_won`
  ADD PRIMARY KEY (`id_bw`);

--
-- Index för tabell `capone_ger`
--
ALTER TABLE `capone_ger`
  ADD PRIMARY KEY (`id_capger`);

--
-- Index för tabell `capone_reg`
--
ALTER TABLE `capone_reg`
  ADD PRIMARY KEY (`id_capreg`);

--
-- Index för tabell `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id_com`);

--
-- Index för tabell `eleicao`
--
ALTER TABLE `eleicao`
  ADD PRIMARY KEY (`id_ele`);

--
-- Index för tabell `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id_event`);

--
-- Index för tabell `liking`
--
ALTER TABLE `liking`
  ADD PRIMARY KEY (`id_lik`);

--
-- Index för tabell `matricula`
--
ALTER TABLE `matricula`
  ADD PRIMARY KEY (`id_mat`);

--
-- Index för tabell `notifs`
--
ALTER TABLE `notifs`
  ADD PRIMARY KEY (`id_not`);

--
-- Index för tabell `parola`
--
ALTER TABLE `parola`
  ADD PRIMARY KEY (`id_parola`);

--
-- Index för tabell `plebs`
--
ALTER TABLE `plebs`
  ADD PRIMARY KEY (`id_plebs`);

--
-- Index för tabell `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id_post`);

--
-- Index för tabell `projetos`
--
ALTER TABLE `projetos`
  ADD PRIMARY KEY (`id_proj`);

--
-- Index för tabell `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Index för tabell `votos`
--
ALTER TABLE `votos`
  ADD PRIMARY KEY (`id_voto`);

--
-- Index för tabell `votpleb`
--
ALTER TABLE `votpleb`
  ADD PRIMARY KEY (`id_vtp`);

--
-- Index för tabell `vot_proj`
--
ALTER TABLE `vot_proj`
  ADD PRIMARY KEY (`id_vop`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `badges`
--
ALTER TABLE `badges`
  MODIFY `id_ba` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT för tabell `badge_won`
--
ALTER TABLE `badge_won`
  MODIFY `id_bw` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `capone_ger`
--
ALTER TABLE `capone_ger`
  MODIFY `id_capger` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT för tabell `capone_reg`
--
ALTER TABLE `capone_reg`
  MODIFY `id_capreg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT för tabell `comment`
--
ALTER TABLE `comment`
  MODIFY `id_com` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT för tabell `eleicao`
--
ALTER TABLE `eleicao`
  MODIFY `id_ele` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT för tabell `events`
--
ALTER TABLE `events`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT för tabell `liking`
--
ALTER TABLE `liking`
  MODIFY `id_lik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT för tabell `matricula`
--
ALTER TABLE `matricula`
  MODIFY `id_mat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT för tabell `notifs`
--
ALTER TABLE `notifs`
  MODIFY `id_not` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT för tabell `parola`
--
ALTER TABLE `parola`
  MODIFY `id_parola` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT för tabell `plebs`
--
ALTER TABLE `plebs`
  MODIFY `id_plebs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT för tabell `posts`
--
ALTER TABLE `posts`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT för tabell `projetos`
--
ALTER TABLE `projetos`
  MODIFY `id_proj` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT för tabell `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT för tabell `votos`
--
ALTER TABLE `votos`
  MODIFY `id_voto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT för tabell `votpleb`
--
ALTER TABLE `votpleb`
  MODIFY `id_vtp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT för tabell `vot_proj`
--
ALTER TABLE `vot_proj`
  MODIFY `id_vop` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
