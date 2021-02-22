CREATE TABLE node_tree
(
    idNode INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    [level] INT,
    iLeft INT,
    iRight INT
)

CREATE TABLE node_tree_names
(
    idNode INT NOT NULL,
    [language] VARCHAR(15),
    nodeName VARCHAR(255),
    FOREIGN KEY (idNode) REFERENCES node_tree(idNode)
)