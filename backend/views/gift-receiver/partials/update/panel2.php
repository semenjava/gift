<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use common\models\Holiday;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\DatesQuery;
use backend\search\GiftSearch;
use common\models\Category;
use common\models\Product;
use common\helpers\StringHelper;
use common\models\Gift;
use common\models\GiftTag;
use common\models\Tag;

$gift = new Gift();
$giftTag = new GiftTag();
$tag = new Tag();
$dateDesk = ArrayHelper::map(Holiday::find()->all(), 'id', 'name');

/* @var $this yii\web\View */
/* @var $model backend\models\GiftReceiver */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="col-lg-12" >
    <div class="col-lg-12">
        <div class="float-right p-xs">
            <?= Html::a('+', 'javascript:void(0);', ['onclick' => 'addInput(this);', 'data-id' => $model->id, 'data-href' => Url::toRoute('dates/create'), 'class' => 'btn btn-success']); ?>
        </div>
    </div>
    <div class="gift-receiver-list" >
        <?php Pjax::begin(); ?>
        <span>Gift Receivers: <?=$model->first_name?> <?=$model->last_name?></span>
        <?=
        GridView::widget([
            'pager' => [
                'lastPageLabel' => '>>',
                'firstPageLabel' => '<<',
                'nextPageLabel' => '>',
                'prevPageLabel' => '<',
            ],
            'dataProvider' => $dataProviderDates,
//            'filterModel' => $searchModelDates,
            'options' => [
                'class' => 'style-table',
                'data-data_id' => $model->id,
                'id' => 'date-table'
            ],
            'columns' => [
//                        ['class' => 'yii\grid\SerialColumn'],
                [
                    'encodeLabel' => false,
                    'label' => '<div class="column-label-grid">' . Yii::t('app', '') . '</div>',
                    'attribute' => 'id',
                    'format' => 'raw',
                    'contentOptions' => [
                        'style' => 'width:50px;',
                    ],
                ],
                [
                    'encodeLabel' => false,
                    'label' => '<div class="column-label-grid">' . Yii::t('app', 'Month Day Year') . '</div>',
                    'attribute' => 'mem_date',
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width:100px;'],
                    'content' => function ($data) {
                        $y = !empty($data->date_y)?'.'.$data->date_y:'';
                        $mem_date = $data->date_m.'.'.$data->date_d.$y;
                        return $mem_date;
                    }
                ],
                [
                    'encodeLabel' => false,
                    'label' => '<div class="column-label-grid">' . Yii::t('app', 'Date Desc') . '</div>',
                    'attribute' => 'id_holiday',
                    'format' => 'raw',
                    'content' => function($data) use ($dateDesk) {
                        return !empty($dateDesk[$data->id_holiday]) ? $dateDesk[$data->id_holiday] : '';
                    },
                    'filter' => Html::dropDownList('GiftSearch[id_category]', 'id_holiday', DatesQuery::dropDownListHoliday(), ['class' => 'form-control chzn-select', 'tabindex' => '2'])
                ],
                [
                    'encodeLabel' => false,
                    'label' => '<div class="column-label-grid">' . Yii::t('app', 'From') . '</div>',
                    'attribute' => 'from',
                    'format' => 'raw',
                    'content' => function($data) {
                        return !empty($data->gift->from) ? $data->gift->from : '';
                    }
                ],
                [
                    'encodeLabel' => false,
                    'label' => '<div class="column-label-grid">' . Yii::t('app', 'To') . '</div>',
                    'attribute' => 'to',
                    'format' => 'raw',
                    'content' => function($data) {
                        return !empty($data->gift->to) ? $data->gift->to : '';
                    }
                ],
                [
                    'encodeLabel' => false,
                    'label' => '<div class="column-label-grid">' . Yii::t('app', 'Tags') . '</div>',
                    'attribute' => 'tags',
                    'format' => 'raw',
                    'content' => function($data) {
                        return $data->gift ? implode(', ', ArrayHelper::getColumn($data->gift->tags, 'name')) : null;
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'width:70px;'],
                    'template' => '{update}{delete}',
                    'buttons' => [
                        'update' => function ($id, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', 'javascript:void(0);', ['data-href' => Url::toRoute('dates/update'), 'data-id' => $id, 'onclick' => 'inputUpdate(this)', 'class' => 'btn btn-xs'], [

                                ]);
                        },
                        'delete' => function ($id, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'javascript:void(0);', ['data-href' => Url::toRoute('dates/delete').'?id='.$id, 'data-id' => $id, 'onclick' => 'inputDelete(this)',
                                    'class' => 'btn btn-xs',
                                    'data-confirm' => 'Are you sure you want to delete this item?',
                                    'data-method' => 'post'
                                ]);
                        }
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'update') {
                            $url = $model->id;
                            return $url;
                        }
                        if ($action === 'delete') {
                            $id = $model->id;
                            $url = Url::toRoute('dates/delete').'?id='.$model->id;
                            return $id;
                        }
                    }
                ],
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>
<?php /*
<div class="bounceInRight col-lg-6 <?=empty($id_date)?'hide':''?>" id="info-content">
    <?php
        $searchModelGift = new GiftSearch();
        $dataProviderGift = $searchModelGift->search(['id_dates' => $id_date]);

        $category = ArrayHelper::map(Category::find()->all(), 'id', 'name');
        $products = ArrayHelper::map(Product::find()->all(), 'id', 'name');

    ?>
            <?php echo  $this->render('../../../gift/index', [
                'searchModel' => $searchModelGift,
                'dataProvider' => $dataProviderGift,
                'category' => $category,
                'products' => $products,
                'date_id' => $id_date,
                'rec' => $model->id
            ])  ?>
</div>
*/ ?>


<script>
    document.addEventListener("DOMContentLoaded", function () {
//        Metis.formGeneral();

//        var hr = '<?=Url::toRoute('gift/index')?>';
//        var rec = <?=$model->id?>; // Gift Receiver id
//        $('#date-table').find('tbody').find('tr').click(function () {
//            var id = $(this).data('key');
//
//            $.get(hr,{'date_id':id, 'rec':rec},function(obj){
//                var htm = $(obj).find('#input-info').html();
//                $('#info-content').html(htm);
//                $('#info-content').removeClass('hide').hide();
//                $('#info-content').show('slow');
//            });
//        });

    });
</script>
