SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `admin_name` varchar(30) NOT NULL,
  `admin_email` varchar(80) NOT NULL,
  `admin_pwd` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `admin` (`id`, `admin_name`, `admin_email`, `admin_pwd`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$TsjH/vsHmSCuq9cDQUVF..kXca8OZB0.Ymh6l.gskq7B/Cj2YAsNW');

CREATE TABLE `devices` (
  `id` int(11) NOT NULL,
  `device_name` varchar(50) NOT NULL,
  `device_uid` text NOT NULL,
  `device_date` date NOT NULL,
  `device_mode` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL DEFAULT 'None',
  `email` varchar(50) NOT NULL DEFAULT 'None',
  `card_uid` varchar(30) NOT NULL,
  `card_select` tinyint(1) NOT NULL DEFAULT '0',
  `user_date` date NOT NULL,
  `device_uid` varchar(20) NOT NULL DEFAULT '0',
  `device_name` varchar(20) NOT NULL DEFAULT '0',
  `add_card` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `users_logs` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `card_uid` varchar(30) NOT NULL,
  `device_uid` varchar(20) NOT NULL,
  `device_name` varchar(20) NOT NULL,
  `checkindate` date NOT NULL,
  `timein` time NOT NULL,
  `timeout` time NOT NULL,
  `card_out` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users_logs`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;