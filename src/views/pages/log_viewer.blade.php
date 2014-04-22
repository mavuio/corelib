

<div ng-bind='query'></div>

Log-Viewer

{{ $listr->topHtml($listrArguments) }}

<!-- <form class="form-inline" ng-submit="listrSubmitQuery()">
    <input type='text' ng-model='query.keyword' class="form-control" style='width:200px' placeholder='Suche nach ...'>
    <button class="btn" type="submit"><i class="fa fa-check"></i> OK</button>
</form>
<div>&nbsp;</div>
<div>&nbsp;</div>
 -->
{{ $listr->middleHtml($listrArguments) }}


{{ $listr->bottomHtml($listrArguments) }}

