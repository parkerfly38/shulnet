<style>
    #calendar table th {
        text-align: center;
        padding: 12px 0 12px 0;
        font-size: 0.9em;
        width:130px;
    }
    #calendar table td {
        height: 100px;
        border-left: 1px solid #e1e1e1;
        border-top: 1px solid #e1e1e1;
        vertical-align: top !important;
        font-size: 0.8em;
    }

    #calendar table td.zen_empty
    {
        background-color: #f1f1f1;
    }

    #calendar table td.zen_last {
        border-right: 1px solid #e1e1e1;
    }

    #calendar table tr.zen_top_line {
        border-top: 1px solid #e1e1e1;
    }

    #calendar table {
        border-bottom: 1px solid #e1e1e1;
    }
    
    p.zen_tagline {
        margin-top: 4px;
    }

    #calendar table td.zen_noevent
    {
        background-color: #f9f9f9;
    }

    .zen_day_number {
        background-color: #f1f1f1;
        -webkit-border-radius: 24px;
        -moz-border-radius: 24px;
        border-radius: 24px;
        float: right;
        padding: 4px 4px 4px 4px;
        margin: 8px 8px 0 0;
        font-size: 0.8em !important;
        font-weight: bold;
    }

    .zen_today a {
        color: #000;
    }

    div.zen_today {
        background-color: #F8A037;
        color: #fff;
    }
    
    .zen_calendar_event {
        padding: 24px;
    }

    .zen_calendar_event p
    {
        margin: 0;
    padding: 0;
    border: 0;
    font-size: 100%;
    font: inherit;
    vertical-align: baseline;
    }

    #zen_calendar_bottom {
        margin: 24px 40px 0 40px;
        font-family: arial, Helvetica, sans-serif;
        font-size: 0.9em !important;
    }

    .zen_event_tag {
        float: left;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;
        width: 8px;
        height: 8px;
        margin-right: 3px;
    }

    ul.zen_tag_legend {
        list-style: none;
        margin: 0;
        float: right;
    }

    ul.zen_tag_legend li {
        padding: 0 0 4px 0;
    }
</style>

<div class="row">
    <div class="col-xl-12 col-lg-12">
        <h1>%title%</h1>

        <p>
            <span><a href="%prev_link%" class="btn btn-primary btn-outline">&laquo; %prev_month%</a></span>
            <span class="zen_divide">&#183;</span>
            <span><strong>%title%</strong></span>
            <span class="zen_divide">&#183;</span>
            <span><a href="%next_link%" class="btn btn-primary btn-outline">%next_month% &raquo;</a></span>
        </p>
        <div id="calendar">%calendar%</div>
        


    </div>
</div>