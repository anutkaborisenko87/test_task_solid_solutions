create table if not exists nodes
(
    id        bigint unsigned auto_increment
        primary key,
    title     varchar(191)    not null,
    parent_id bigint unsigned null,
    constraint nodes_nodes_id_fk
        foreign key (parent_id) references nodes (id)
            on delete cascade
);


