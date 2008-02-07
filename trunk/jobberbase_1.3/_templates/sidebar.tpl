			{if $CURRENT_PAGE != ''}
			<a href="{$BASE_URL}" title="IT jobs">&laquo; home</a><br />
			{/if}
			
			{if $smarty.session.last_viewed_jobs}
			<h4>Seen recently</h4>
			<ul>
				{section name=last loop=$smarty.session.last_viewed_jobs}
				<li><a href="{$smarty.session.last_viewed_jobs[last].url}">&raquo; {$smarty.session.last_viewed_jobs[last].title}</a></li>
				{/section}
			</ul>
			{/if}
			
			{if $CURRENT_PAGE == ''}
			<br />
			<div id="stats">
				<strong>{$jobs_count_all} total jobs</strong>
				<br />
				{foreach item=job from=$jobs_count_all_categs}
				<strong>{$job.categ_count}</strong> for <a href="{$BASE_URL}jobs/{$job.categ_varname}/">{$job.categ_name}</a><br />
				{/foreach}
			</div><!-- #stats -->
			{/if}