
<nav class="row mb-3">
    <ul class="pagination mx-auto">
    <li class="page-item">
        <a class="page-link" href="<?php if($total_pages == 1){echo '#';}else{echo '?pageno=1';}?>">First</a>
    </li>
    <li class="page-item <?php if($pageno <= 1){ echo 'disabled';}?>">
        <a class="page-link" href="<?php if($pageno <= 1){echo '#';}else{echo '?pageno='.($pageno-1);}?>">Previous</a>
    </li>
    <li class="page-item"><a class="page-link" href="#"><?= $pageno; ?></a></li>

    <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled';}?>">
        <a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#';}else{echo '?pageno='.($pageno+1);}?>">Next</a>
    </li>
    <li class="page-item"><a class="page-link" href="<?= ($total_pages == 1) ? '#' : '?pageno='.$total_pages;?>">Last</a></li>
    </ul>
</nav>