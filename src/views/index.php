
<div class="mb">
    <a href="?p=new" role="button">New</a>
    <a href="?p=logout" role="button">Logout</a>
</div>

<div class="cards">

    <?php foreach($rows as $row) { ?>
        <article>
            <h3><?=$row['titel'];?></h3>
            <div class="float-end">
                <button class="copy-btn">Copy</button>
                <a role="button" href="?p=delete&id=<?=$row['id'];?>">Delete</a>
            </div>
            <div class="key" data-id="<?=$row['id'];?>"></div>
        </article>
    <?php } ?>
</div>


<script>
    update = () => {
        document.querySelectorAll(".key").forEach((item) => {
            fetch('/?p=get&id=' + item.getAttribute('data-id')).then((res) => {
                res.json().then((data) => {
                    let newItem = '<span>' + data.totp + '</span>';
                    newItem +=  '<div class="progressbar"><div style="width: ' + (data.time / 30 * 100) + '%"></div></div>';
                    
                    item.innerHTML = newItem;
                });
            });
        });
    };

    update();
    setInterval(update, 1000);

    document.addEventListener('click',(item) => {

        if(item.target.classList.contains("copy-btn")){
            let code = item.target.parentElement.parentElement.querySelector('span').innerHTML;

            navigator.clipboard.writeText(code);
        }
    });
</script>