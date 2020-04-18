<div class="container">

    <div class="row">
        <?php $mostCommentedArray = $mostCommented->map(function ($el) {
            return ['title' => $el->title, 'href' => route('posts.show', ['post' => $el->id]), 'count' => $el->comments_count];
        });?>
        <x-card title="Most Commented"
                subtitle="What people are currently talking about"
                :items="$mostCommentedArray"/>
    </div>


    <div class="row">
        <?php $mostActiveArray = $mostActive->map(function ($el) {
            return ['title' => $el->name, 'href' => '', 'count' => $el->posts_count];
        });?>
        <x-card title="Most Active Users"
                subtitle="Writers with most posts written"
                :items="$mostActiveArray"/>
    </div>

    <div class="row">
        <?php $mostActiveLastMonthArray = $mostActiveLastMonth->map(function ($el) {
            return ['title' => $el->name, 'href' => '', 'count' => $el->posts_count];
        });?>
        <x-card title="Most Active Users Last Month"
                subtitle="Writers with most posts written in the last month"
                :items="$mostActiveLastMonthArray"/>
    </div>

</div>
