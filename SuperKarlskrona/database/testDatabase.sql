-- test proc
 CALL add_topic('message', 1, @return);
 SELECT @return;

INSERT INTO `topic`(`tid`, `name`, `like`, `dislike`, `color`, `description`, `code`) VALUES
(2,"me1",1,7, "lightpink", "test topic 1", "1"),
(3,"me2",2,6, "lightblue", "test topic 2", "2"),
(4,"me3",3,5, "lightgreen", "test topic 3", "3"),
(5,"me4",4,4, "lightpink", "test topic 4", "4"),
(6,"me5",5,3, "yellow", "test topic 5", "5"),
(7,"me6",6,2, "lightgreen", "test topic 6", "6"),
(8,"me7",7,1, "lightpink", "test topic 7", "7")
