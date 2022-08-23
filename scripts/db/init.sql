CREATE TABLE IF NOT EXISTS menu(
	id serial PRIMARY KEY,
	title varchar(255) NOT NULL);

CREATE TABLE IF NOT EXISTS product(
	id serial PRIMARY KEY,
	title varchar(255) NOT NULL,
	price decimal NOT NULL,
	menu_id bigint NOT NULL,
	CONSTRAINT fk_menu
		FOREIGN KEY(menu_id)
		REFERENCES menu
		ON DELETE CASCADE
);
