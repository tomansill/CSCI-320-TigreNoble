CREATE PROCEDURE `createStudent`(
IN student_dce VARCHAR(7),
IN student_name VARCHAR(100),
IN student_email VARCHAR(20)
)BEGIN
INSERT INTO tigrenoble.Student (dce, name, email) VALUES (student_dce, student_name, student_email);
END#

CREATE PROCEDURE `getBook`(IN `book_isbn` BIGINT(13))
BEGIN
SELECT * FROM tigrenoble.Book WHERE isbn = book_isbn;
END#

CREATE PROCEDURE `getHighestBid`(IN post_id INT)
BEGIN
SELECT MAX(bid_amount) FROM tigrenoble.Bid_money WHERE posting_id = post_id;
END#

CREATE PROCEDURE `insertBook`(IN `book_isbn` BIGINT, IN `book_title` VARCHAR(100), IN `book_author` VARCHAR(100), IN `book_publisher` VARCHAR(100), IN `book_edition` SMALLINT, IN `book_description` TEXT, IN `book_year` int)
BEGIN
INSERT INTO tigrenoble.Book  
(year_written, isbn, title, author, publisher, edition, description)  
VALUES 
(book_year, book_isbn, book_title, book_author, book_publisher, book_edition, book_description); 
END#

CREATE PROCEDURE `insertPost`(IN `seller` VARCHAR(7), IN `bookid` BIGINT(13), IN `bookcondition` VARCHAR(10), IN `bookprice` INT, IN `posttype` CHAR, IN `bookdescription` TEXT, IN `bookquantity` INT, IN `imgPath` TEXT)
BEGIN
INSERT INTO tigrenoble.Post 
(seller_dce, book_isbn, book_condition, book_price, post_date, 
post_description, post_type, book_quantity, post_status,imagePath) 
VALUES
(seller, bookid, bookcondition, bookprice, now(), bookdescription, posttype, bookquantity,'A',imgPath);
END#

CREATE PROCEDURE `makeBid_Money`(IN `post_id` INT, IN `customer_dce` VARCHAR(100), IN `amount` INT)
BEGIN
INSERT INTO tigrenoble.Bid_money (posting_id, student_dce, bid_amount, bid_accept) VALUES (post_id, customer_dce, amount, FALSE);
END#

CREATE PROCEDURE `getPost`(IN `post_id` INT)
BEGIN
SELECT * FROM Post INNER JOIN tigrenoble.Book ON Post.book_isbn = Book.isbn WHERE id = post_id;
END#

CREATE PROCEDURE `searchPost`(IN `query` VARCHAR(300))
BEGIN
SELECT * FROM Post INNER JOIN tigrenoble.Book ON Post.book_isbn = Book.isbn WHERE Book.title LIKE CONCAT('%', CONCAT(query, '%')) OR Book.isbn LIKE Book.title OR Book.author LIKE CONCAT('%', CONCAT(query, '%'));
END#

CREATE PROCEDURE `acceptMoneyBid`(IN `post_id` INT, IN `customer_dce` VARCHAR(7))
BEGIN
UPDATE tigrenoble.Bid_money SET bid_accept = 'A' WHERE posting_id = post_id AND student_dce = customer_dce;
UPDATE tigrenoble.Post SET post_status = 'S' WHERE id = post_id;
END#

CREATE PROCEDURE `acceptMoneyBidId`(IN `bid_id` INT)
BEGIN
UPDATE tigrenoble.Bid_money SET bid_accept = 'A' WHERE id = bid_id;
UPDATE tigrenoble.Post SET post_status = 'S' WHERE id = (SELECT posting_id FROM Bid_money WHERE id = bid_id);
END#

CREATE PROCEDURE `rejectMoneyBid`(IN `post_id` INT, IN `customer_dce` VARCHAR(7))
BEGIN
UPDATE tigrenoble.Bid_money SET bid_accept = 'R' WHERE posting_id = post_id AND student_dce = customer_dce;
END#

CREATE PROCEDURE `rejectMoneyBidId`(IN `bid_id` INT)
BEGIN
UPDATE tigrenoble.Bid_money SET bid_accept = 'R' WHERE id = bid_id;
END#

CREATE PROCEDURE `acceptTradeBid`(IN `post_id` INT, IN `customer_dce` VARCHAR(7))
BEGIN
UPDATE tigrenoble.Bid_trade SET trade_accept = 'A' WHERE posting_id = post_id AND student_dce = customer_dce;
UPDATE tigrenoble.Post SET post_status = 'S' WHERE id = post_id;
END#

CREATE PROCEDURE `acceptTradeBidId`(IN `bid_id` INT)
BEGIN
UPDATE tigrenoble.Bid_trade SET trade_accept = 'A' WHERE id = bid_id;
UPDATE tigrenoble.Post SET post_status = 'S' WHERE id = (SELECT posting_id FROM Bid_trade WHERE id = bid_id);
END#

CREATE PROCEDURE `rejectTradeBid`(IN `post_id` INT, IN `customer_dce` VARCHAR(7))
BEGIN
UPDATE tigrenoble.Bid_trade SET trade_accept = 'R' WHERE posting_id = post_id AND student_dce = customer_dce;
END#

CREATE PROCEDURE `rejectTradeBidId`(IN `bid_id` INT)
BEGIN
UPDATE tigrenoble.Bid_trade SET trade_accept = 'R' WHERE id = bid_id;
END#

CREATE PROCEDURE `getListOfBidsMoney`(IN `dce` VARCHAR(7))
BEGIN
SELECT * FROM tigrenoble.Bid_money WHERE student_dce = dce AND Bid_money.bid_accept = 'P';
END#

CREATE PROCEDURE `getListOfBidsTrade`(IN `dce` VARCHAR(7))
BEGIN
SELECT * FROM tigrenoble.Bid_trade WHERE student_dce = dce AND Bid_trade.trade_accept = 'P';
END#


CREATE PROCEDURE `getListOfBidsMoneySeller`(IN `dce` VARCHAR(7))
BEGIN
SELECT Bid_money.id, Bid_money.posting_id, Bid_money.student_dce, Bid_money.bid_amount FROM Post, Bid_money where Post.id = Bid_money.posting_id AND Post.seller_dce = dce AND Bid_money.bid_accept = 'P';
END#

CREATE PROCEDURE `getListOfBidsTradeSeller`(IN `dce` VARCHAR(7))
BEGIN
SELECT Bid_trade.id, Bid_trade.posting_id, Bid_trade.student_dce, Bid_trade.offer_message FROM Post, Bid_trade where Post.id = Bid_trade.posting_id AND Post.seller_dce = dce AND Bid_trade.trade_accept = 'P';
END#

CREATE PROCEDURE `makeMoneyBid`(IN `post_id` INT, IN `customer_dce` VARCHAR(7), IN `money_amount` INT)
BEGIN
INSERT INTO tigrenoble.Bid_money (posting_id, student_dce, bid_amount, bid_accept) VALUES(post_id, customer_dce, money_amount, 'P');
END#

CREATE PROCEDURE `makeTradeBid`(IN `post_id` INT, IN `customer_dce` VARCHAR(7), IN `trade_offer` TEXT)
BEGIN
INSERT INTO tigrenoble.Bid_trade (posting_id, student_dce, offer_message, trade_accept) VALUES(post_id, customer_dce, trade_offer, 'P');
END#

CREATE PROCEDURE `getRandomListOfPosts`()
BEGIN
(SELECT * FROM Post INNER JOIN Book ON Post.book_isbn = Book.isbn WHERE post_status = 'A' ORDER BY post_date DESC LIMIT 10) ORDER BY RAND();
END#

CREATE PROCEDURE `getListOfMessages`(IN dce VARCHAR(7))
BEGIN
SELECT id, sender_dce, dateReceived, subject, message FROM Inbox WHERE receiver_dce = dce ORDER BY dateReceived DESC;
END#

CREATE PROCEDURE `getMessage`(IN message_id INT, IN dce VARCHAR(7))
BEGIN
SELECT sender_dce, dateReceived, subject, message FROM Inbox WHERE id = message_id AND receiver_dce = dce;
END#

CREATE PROCEDURE `sendMessage`(IN sender VARCHAR(7), IN receipent VARCHAR(7), IN subject_msg VARCHAR(100), IN message_content TEXT)
BEGIN
  IF EXISTS (SELECT dce FROM Student WHERE dce = receipent) THEN INSERT INTO Inbox (sender_dce, receiver_dce, dateReceived, subject, message) VALUES (sender, receipent, now(), subject_msg, message_content); END IF;
END#

CREATE PROCEDURE `getListOfBidsMoneySellerWithMoreInfo`(IN `dce` VARCHAR(7))
BEGIN
SELECT * FROM tigrenoble.Bid_money INNER JOIN (SELECT * FROM tigrenoble.Post INNER JOIN tigrenoble.Book ON tigrenoble.Post.book_isbn = tigrenoble.Book.isbn) as newTable ON tigrenoble.Bid_money.posting_id = tigrenoble.newTable.id WHERE newTable.seller_dce = dce AND Bid_money.bid_accept = 'P' ;
END#

CREATE PROCEDURE `getListOfBidsTradeSellerWithMoreInfo`(IN `dce` VARCHAR(7))
BEGIN
SELECT * FROM tigrenoble.Bid_trade INNER JOIN (SELECT * FROM tigrenoble.Post INNER JOIN tigrenoble.Book ON tigrenoble.Post.book_isbn = tigrenoble.Book.isbn) as newTable ON tigrenoble.Bid_trade.posting_id = tigrenoble.newTable.id WHERE newTable.seller_dce = dce AND Bid_trade.trade_accept = 'P';
END#

