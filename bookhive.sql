-- Run Apache and MySQL on XAMPP
-- Go to loalhost/phpmyadmin
-- Click on New
-- Database name: bookhive
-- Click on Create button
-- Go to SQL tab to write queries

-- Books Table **************************************************************************************************************************************
CREATE TABLE Books(
    book_id int AUTO_INCREMENT PRIMARY KEY, -- This is so we don't have to write new id's every time
    author varchar(255) NOT NULL,
    title varchar(255) NOT NULL,
    genre varchar(255) NOT NULL,
    description varchar(255) NOT NULL,
    checked_out_by varchar(255)
);

INSERT INTO Books (author, title, genre, description)
VALUES ('John Doe', 'The Great Adventure', 'Adventure', 'A thrilling journey across the world.');

INSERT INTO Books (author, title, genre, description)
VALUES ('Jane Smith', 'Mystery at Midnight', 'Mystery', 'A suspenseful tale of crime and investigation.');

INSERT INTO Books (author, title, genre, description)
VALUES ('George Orwell', '1984', 'Dystopian Fiction', 'A classic novel depicting a totalitarian society.');

INSERT INTO Books (author, title, genre, description)
VALUES ('Ernest Hemingway', 'The Sun Also Rises', 'Fiction', 'A story of disillusioned expatriates in post-World War I Europe.');

INSERT INTO Books (author, title, genre, description)
VALUES ('Agatha Christie', 'And Then There Were None', 'Mystery', 'Ten strangers trapped on an isolated island face a deadly game of deception.');

INSERT INTO Books (author, title, genre, description)
VALUES
    ('Dale Carnegie', 'How to Win Friends and Influence People', 'Business', 'A classic self-help book that provides practical advice on how to build relationships, win people over, and influence others in both personal and professional settings.'),
    ('Simon Sinek', 'Start with Why: How Great Leaders Inspire Everyone to Take Action', 'Business', 'This book explores the concept of finding your "why" as a leader and how it can inspire and motivate others to follow.'),
    ('Stephen R. Covey', 'The 7 Habits of Highly Effective People', 'Business', 'A bestselling book that presents a holistic approach to personal and professional effectiveness, focusing on principles such as proactivity, prioritization, and synergy.'),
    ('Daniel Kahneman', 'Thinking, Fast and Slow', 'Business', 'This book delves into the psychology of decision-making, highlighting the biases and heuristics that influence our choices and offering insights to make better decisions.'),
    ('Michael E. Porter', 'Competitive Strategy: Techniques for Analyzing Industries and Competitors', 'Business', 'Porter presents frameworks and concepts to analyze industry competition and develop effective strategies to gain a competitive advantage.');

INSERT INTO Books (author, title, genre, description)
VALUES
    ('J.K. Rowling', 'Harry Potter and the Sorcerer\'s Stone', 'Entertainment', 'The first book in the popular Harry Potter series, following the magical adventures of a young wizard and his friends.'),
    ('George R.R. Martin', 'A Game of Thrones', 'Entertainment', 'The first book in the epic fantasy series "A Song of Ice and Fire," known for its complex characters, political intrigue, and sprawling world.'),
    ('Suzanne Collins', 'The Hunger Games', 'Entertainment', 'Set in a dystopian future, this book introduces a young heroine who must fight for survival in a brutal televised competition.'),
    ('J.R.R. Tolkien', 'The Lord of the Rings', 'Entertainment', 'A classic fantasy trilogy that follows a group of individuals on a quest to destroy a powerful ring and save Middle-earth from darkness.'),
    ('Agatha Christie', 'Murder on the Orient Express', 'Entertainment', 'Renowned detective Hercule Poirot investigates a murder that occurs aboard the luxurious Orient Express, trapping the suspects on a train.'),
    ('Dan Brown', 'The Da Vinci Code', 'Entertainment', 'A thrilling mystery that combines art, history, and religion, as a symbologist races to uncover a secret that could change the course of history.'),
    ('E.L. James', 'Fifty Shades of Grey', 'Entertainment', 'A controversial romance novel exploring the intense relationship between a college graduate and a young businessman, delving into themes of power dynamics and desire.'),
    ('Gillian Flynn', 'Gone Girl', 'Entertainment', 'A gripping psychological thriller about a husband who becomes the prime suspect in his wife\'s disappearance, filled with twists and turns.'),
    ('Jojo Moyes', 'Me Before You', 'Entertainment', 'A heartwarming and emotional story of an unlikely relationship between a caregiver and a paralyzed man, challenging their perspectives on life and love.'),
    ('Andy Weir', 'The Martian', 'Entertainment', 'A science fiction novel that follows an astronaut stranded on Mars, as he uses his ingenuity to survive and find a way back home.');

INSERT INTO Books (author, title, genre, description)
VALUES
    ('George Orwell', '1984', 'Politics', 'A dystopian novel that portrays a totalitarian society where individuality and freedom are suppressed, and the government manipulates and controls its citizens.'),
    ('Machiavelli', 'The Prince', 'Politics', 'A classic treatise on political power and leadership, offering advice on how rulers can acquire and maintain power in a politically turbulent environment.'),
    ('Hannah Arendt', 'The Origins of Totalitarianism', 'Politics', 'An influential work that examines the rise of totalitarian regimes and analyzes the political, social, and ideological factors that contribute to their emergence.'),
    ('Yuval Noah Harari', 'Sapiens: A Brief History of Humankind', 'Politics', 'Harari explores the history and impact of Homo sapiens, discussing the development of political systems, ideologies, and the role of humans in shaping the world.'),
    ('Thomas Piketty', 'Capital in the Twenty-First Century', 'Politics', 'An economic analysis of wealth and income inequality, discussing the historical patterns of capital accumulation and proposing policy solutions to address inequality.');

INSERT INTO Books (author, title, genre, description)
VALUES
    ('Michael Lewis', 'Moneyball: The Art of Winning an Unfair Game', 'Sports', 'Lewis explores the innovative use of data and analytics in baseball, focusing on the Oakland Athletics and their manager, Billy Beane.'),
    ('Phil Knight', 'Shoe Dog: A Memoir by the Creator of Nike', 'Sports', 'Knight shares the story of Nikes founding and his personal journey in building one of the worlds most iconic sports brands.'),
    ('Bill Simmons', 'The Book of Basketball: The NBA According to The Sports Guy', 'Sports', 'Simmons presents an entertaining and insightful look at the history, players, and cultural impact of the NBA.'),
    ('Jon Krakauer', 'Into the Wild', 'Sports', 'Krakauer tells the true story of Chris McCandless, a young man who ventured into the Alaskan wilderness to live a solitary and nomadic life.'),
    ('Andre Agassi', 'Open', 'Sports', 'Agassis memoir chronicles his life and career as a professional tennis player, providing a candid account of his successes, struggles, and personal growth.'),
    ('Laura Hillenbrand', 'Seabiscuit: An American Legend', 'Sports', 'Hillenbrand recounts the inspiring story of Seabiscuit, a racehorse that captured the hearts of Americans during the Great Depression.'),
    ('Walter Iooss Jr.', 'Rare Air: Michael on Michael', 'Sports', 'Iooss captures iconic photographs of Michael Jordan and presents a visual journey through the life and career of one of basketballs greatest players.');

INSERT INTO Books (author, title, genre, description)
VALUES
    ('Walter Isaacson', 'Steve Jobs', 'Tech', 'Isaacson presents a comprehensive biography of Steve Jobs, co-founder of Apple Inc., delving into his personal and professional life as a visionary and innovator.'),
    ('Ray Kurzweil', 'The Singularity Is Near: When Humans Transcend Biology', 'Tech', 'Kurzweil explores the concept of technological singularity, discussing the potential impacts of artificial intelligence, biotechnology, and nanotechnology on humanity.'),
    ('Sherry Turkle', 'Alone Together: Why We Expect More from Technology and Less from Each Other', 'Tech', 'Turkle examines the social and psychological effects of our increasing reliance on technology, questioning the impact on human connection and interaction.'),
    ('Nick Bostrom', 'Superintelligence: Paths, Dangers, Strategies', 'Tech', 'Bostrom explores the potential risks and benefits of artificial general intelligence and discusses strategies for ensuring its safe development and deployment.'),
    ('Yuval Noah Harari', 'Homo Deus: A Brief History of Tomorrow', 'Tech', 'Building on his previous work "Sapiens," Harari speculates on the future of humanity, discussing the impact of technology and the potential for human enhancement.'),
    ('Cathy O\'Neil', 'Weapons of Math Destruction: How Big Data Increases Inequality and Threatens Democracy', 'Tech', 'O\'Neil examines the potential biases and negative consequences of algorithms and big data in various domains, from education to criminal justice.'),
    ('Andrew McAfee and Erik Brynjolfsson', 'The Second Machine Age: Work, Progress, and Prosperity in a Time of Brilliant Technologies', 'Tech', 'The authors discuss the economic implications of advancing technologies, such as robotics and artificial intelligence, and propose strategies for managing the future of work.'),
    ('Elon Musk', 'Elon Musk: Tesla, SpaceX, and the Quest for a Fantastic Future', 'Tech', 'Ashlee Vance provides an in-depth look into the life and ambitious endeavors of Elon Musk, entrepreneur and visionary behind companies like Tesla and SpaceX.'),
    ('Douglas Rushkoff', 'Program or Be Programmed: Ten Commands for a Digital Age', 'Tech', 'Rushkoff explores the implications of living in a digital age and emphasizes the importance of understanding and actively participating in the programming of technology.');


-- Members Table **************************************************************************************************************************************

CREATE TABLE Members(
    member_id int AUTO_INCREMENT PRIMARY KEY, -- This is so we don't have to write new id's every time
    first_name varchar(255) NOT NULL,
    last_name varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    password varchar(255) NOT NULL -- For "next steps" we need to mention that we will encrypt passwords for security reasons
);

INSERT INTO Members (first_name, last_name, email, password)
VALUES ('m_first', 'm_last', 'member@bookhive.com', '123');

INSERT INTO Members (first_name, last_name, email, password)
VALUES ('Alice', 'Johnson', 'alice.johnson@bookhive.com', 'password123');

INSERT INTO Members (first_name, last_name, email, password)
VALUES ('Robert', 'Davis', 'robert.davis@bookhive.com', 'secret123');

INSERT INTO Members (first_name, last_name, email, password)
VALUES ('Michelle', 'Anderson', 'michelle.anderson@bookhive.com', 'mysecurepass');

INSERT INTO Members (first_name, last_name, email, password)
VALUES ('Daniel', 'Wilson', 'daniel.wilson@bookhive.com', 'pass123word');

INSERT INTO Members (first_name, last_name, email, password)
VALUES ('Sophia', 'Brown', 'sophia.brown@bookhive.com', 'strongpassword');

-- Librarians Table **************************************************************************************************************************************

CREATE TABLE Librarians(
    librarian_id int AUTO_INCREMENT PRIMARY KEY, -- This is so we don't have to write new id's every time
    first_name varchar(255) NOT NULL,
    last_name varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    password varchar(255) NOT NULL -- For "next steps" we need to mention that we will encrypt passwords for security reasons
); 

INSERT INTO Librarians (first_name, last_name, email, password)
VALUES ('l_first', 'l_last', 'librarian@bookhive.com', '123');

INSERT INTO Librarians (first_name, last_name, email, password)
VALUES ('Ethan', 'Smith', 'ethan.smith@bookhive.com', 'securepass123');

INSERT INTO Librarians (first_name, last_name, email, password)
VALUES ('Olivia', 'Taylor', 'olivia.taylor@bookhive.com', 'password789');

INSERT INTO Librarians (first_name, last_name, email, password)
VALUES ('Liam', 'Wilson', 'liam.wilson@bookhive.com', 'strongpass321');

INSERT INTO Librarians (first_name, last_name, email, password)
VALUES ('Ava', 'Anderson', 'ava.anderson@bookhive.com', 'mypassword456');

INSERT INTO Librarians (first_name, last_name, email, password)
VALUES ('Noah', 'Brown', 'noah.brown@bookhive.com', 'password1234');
