<!-- Button trigger modal -->
<button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#createRootModal">
    + New root
</button>

<!-- Create root Modal -->
<div class="modal fade" id="createRootModal" tabindex="-1" aria-labelledby="createRootModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRootModalLabel">Create root</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="createRoot" action="/new_root" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Root title</label>
                        <input type="text" class="form-control" name="title" id="title" aria-describedby="titleError"
                               required>
                        <small id="titleError" class="form-text text-danger" style="display: none;"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save root</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Create node Modal -->
<div class="modal fade" id="createNodeModal" tabindex="-1" aria-labelledby="createNodeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createNodeModalLabel">Create node</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="createNode" action="/new_node" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Node title</label>
                        <input type="hidden" name="parent_id" id="parent_id">
                        <input type="text" class="form-control" name="title" id="title" aria-describedby="titleError"
                               required>
                        <small id="titleError" class="form-text text-danger" style="display: none;"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save node</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Create node Modal -->
<div class="modal fade" id="deleteRootModal" tabindex="-1" aria-labelledby="deleteRootModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createNodeModalLabel">Delete confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <p>This is very dangerous. You shouldn`t do it! Are you really sure?</p>

                </div>
            <form id="deleteRoot" action="/delete_root" method="post">
                <input type="hidden" name="root_id" id="root_id">
                <div class="modal-footer justify-content-between">
                    <div>
                        <strong><span class="text-danger" id="timer"></span></strong>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-danger">Dlete Root</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!--<ul class="topmenu">-->
    <?php
    function renderMenu($menuItems, $class = "topmenu")
    {
        echo '<ul class="' . $class . '">';
        foreach ($menuItems as $item) {
            echo '<li>';
            echo '<a href="#">' . (!empty($item['nodes']) ? '<span class="menu-icon">▶</span>' : '') . $item['title'] .

                '<button type="button" class="btn btn-outline-success btn-sm create_node"
                                            data-parentId="' . $item['id'] .'"
                                    >+
                                    </button></a>';
            if (!empty($item['nodes'])) {
                $class = isset($item['depth']) && $item['depth'] === 0 ? "submenu" : "submenu subsubmenu";
                renderMenu($item['nodes'], $class);
            }
            echo '</li>';
        }
        echo '</ul>';
    }

    foreach ($contentdata as $item) {
        if (is_null($item['parent_id'])) {
            ?>
            <div class="row">
                <div class="nav">
                    <ul class="topmenu">
                        <?php
                        if (!empty($item['nodes'])) {
                            ?>
                                <li>
                                    <a href="#"><span class="menu-icon">▶</span><?= $item['title'] ?>
                                        <button type="button" class="btn btn-outline-success btn-sm create_node"
                                                data-parentId="<?= $item['id'] ?>"
                                        >+</button>
                                        <button type="button" class="btn btn-outline-danger btn-sm delete_root"
                                                data-parentId="<?= $item['id'] ?>"
                                                data-toggle="modal"
                                                data-target="#deleteRootModal">-</button>
                                    </a>
                                    <?php renderMenu($item['nodes'], 'submenu');?>
                                </li>
                            <?php
                        } else {
                            ?>
                                <li>
                                    <a href="#"><?= $item['title'] ?>
                                        <button type="button" class="btn btn-outline-success btn-sm create_node"
                                                data-parentId="<?= $item['id'] ?>"
                                                data-toggle="modal"
                                                data-target="#createNodeModal">+</button>
                                        <button type="button" class="btn btn-outline-danger btn-sm delete_root"
                                                data-parentId="<?= $item['id'] ?>"
                                                data-toggle="modal"
                                                data-target="#deleteRootModal">-</button>
                                    </a>
                                </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>
