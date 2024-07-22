CREATE TABLE Users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Recipes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    preparation_time INT, -- in minutes
    cooking_time INT, -- in minutes
    number_of_shares INT DEFAULT 0,
    number_of_downloads INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES Users(id)

);

CREATE TABLE Ingredients (
    id INT PRIMARY KEY AUTO_INCREMENT,
    recipe_id INT,
    name VARCHAR(100) NOT NULL,
    quantity VARCHAR(50),
    FOREIGN KEY (recipe_id) REFERENCES Recipes(id)
);

CREATE TABLE RecipeSteps (
    recipe_id INT,
    step_number INT,
    instruction TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (recipe_id, step_number),
    FOREIGN KEY (recipe_id) REFERENCES Recipes(id)
);

CREATE TABLE Comments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    recipe_id INT,
    user_id INT,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (recipe_id) REFERENCES Recipes(id),
    FOREIGN KEY (user_id) REFERENCES Users(id)
);

CREATE TABLE Ratings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    recipe_id INT,
    user_id INT,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (recipe_id) REFERENCES Recipes(id),
    FOREIGN KEY (user_id) REFERENCES Users(id)
);

CREATE TABLE Favorites (
    user_id INT,
    recipe_id INT,
    PRIMARY KEY (user_id, recipe_id),
    FOREIGN KEY (user_id) REFERENCES Users(id),
    FOREIGN KEY (recipe_id) REFERENCES Recipes(id)
);

