CREATE TABLE `users` (
  `id` auto_increment PRIMARY KEY NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum NOT NULL,
  `password` varchar(60) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
);

CREATE TABLE `posts` (
  `id` auto_increment PRIMARY KEY NOT NULL,
  `users_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `views` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `published` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
);

CREATE TABLE `topics` (
  `id` auto_increment PRIMARY KEY NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(255) NOT NULL
);

CREATE TABLE `posts_topics` (
  `id` auto_increment PRIMARY KEY NOT NULL,
  `posts_id` int NOT NULL,
  `topics_id` int NOT NULL
);

ALTER TABLE `posts` ADD FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

ALTER TABLE `posts` ADD FOREIGN KEY (`id`) REFERENCES `posts_topics` (`posts_id`);

ALTER TABLE `topics` ADD FOREIGN KEY (`id`) REFERENCES `posts_topics` (`topics_id`);
