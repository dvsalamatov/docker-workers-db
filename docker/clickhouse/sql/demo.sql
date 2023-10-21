CREATE TABLE stat
(
    timestamp datetime,
    url text,
    countLine Int32,
    length Int32
) ENGINE = MergeTree
PRIMARY KEY timestamp;
