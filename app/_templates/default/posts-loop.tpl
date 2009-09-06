{if $is_home == 1}
<div><a href="{$BASE_URL}">&laquo; home</a></div>
{/if}
{if $no_categ != 1}
<table id="job-posts" class="job-posts" cellspacing="0">
{if $keywords}
	<tr><td colspan="3" class="search_results_label">
		Search results for <strong>{$keywords}</strong>:
	</td></tr>
{/if}
{if !$jobs}
<div id="no-ads">
	{if $CURRENT_PAGE != 'search'}
	{$translations.jobs.no_job} <strong>{$current_category_name}</strong>.
	{if $smarty.const.ENABLE_NEW_JOBS}
		<br /><a href="{$BASE_URL}post/" title="{$translations.footer.new_job_title}">{$translations.footer.new_job}</a>
	{/if}
	{else}
	{$translations.jobs.no_job_found}<br />
	{/if}
</div><!-- #no-ads -->
{/if}
{foreach item=job from=$jobs}
	<tr {cycle values='class="alt",'}>
		<td>
			<img src="{$BASE_URL}_templates/{$THEME}/img/icon-{$job.type_var_name}.png" alt="{$job.type_name}" />
			<a href="{$BASE_URL}{$URL_JOB}/{$job.id}/{$job.url_title}/" title="{$job.title}">{$job.title}</a> <span class="la">{$translations.homepage.at}</span> {$job.company}{if $job.is_location_anywhere}, {$translations.jobs.location_anywhere}{else} <span class="la">{$translations.homepage.in}</span> {$job.location}{/if}
		</td>
		<td class="time-posted"><img src="{$BASE_URL}_templates/{$THEME}/img/clock.gif" alt="" /> {$job.created_on}</td>
	</tr>
{/foreach}
</table>
<br/>
{$pages}
{/if}