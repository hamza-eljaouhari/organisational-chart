<?php 

function ensureExistence($param){
    if(isset($_GET[$param])){
        return $_GET[$param];
    }

    return null;
}

function getQuery(){
    return "
                SELECT Child.idNode AS node_id, Ntm.nodeName AS name
                    FROM node_tree as Parent, node_tree as Child
                    INNER JOIN node_tree_names AS Ntm
                        ON Child.idNode = Ntm.idNode
                            AND Ntm.language = :LANGUAGE
                            AND Ntm.nodeName LIKE CONCAT('%', :SEARCH_KEYWORD, '%')
                    WHERE
                        Child.level = Parent.level + 1
                        AND Child.iLeft > Parent.iLeft
                        AND Child.iRight < Parent.iRight
                        AND Parent.idNode = :NODE_ID
                    LIMIT :OFFSET, :PAGE_SIZE;";
}