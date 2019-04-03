{*<!-- {[The file is published on the basis of YetiForce Public License 3.0 that can be found in the following directory: licenses/LicenseEN.txt or yetiforce.com]} -->*}
{strip}
    <div class="tpl-Products-Tree-Product card mb-4 box-shadow">
        <div class="card-header">
            <h4 class="my-0 font-weight-normal">{$RECORD->get('productname')}</h4>
        </div>
        <div class="card-body">
            <h5 class="card-title pricing-card-title">{$RECORD->get('unit_price')}</h5>
            {assign var="IMAGES" value=$RECORD->get('imagename')}
            {if empty($IMAGES) }
                NO IMG
            {else}
                <img style="width: 100px" src="data:image/jpeg;base64,{$IMAGES[0]}" />
            {/if}
            <button type="button" class="btn btn-lg btn-block btn-outline-primary">Sign up for free</button>
        </div>
    </div>
{/strip}
