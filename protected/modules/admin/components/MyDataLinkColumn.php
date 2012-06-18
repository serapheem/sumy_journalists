<?php
/**
 * MyDataLinkColumn class file.
 *
 * @author Serapheem
 */

Yii::import('zii.widgets.grid.CDataColumn');

/**
 * MyDataLinkColumn represents a grid view column that renders a hyperlink in each of its data cells with data cell functionality.
 *
 * @author Serahpeem
 */
class MyDataLinkColumn extends CDataColumn
{
	/**
	 * @var string the label to the hyperlinks in the data cells. Note that the label will not
	 * be HTML-encoded when rendering. This property is ignored if {@link labelExpression} is set.
	 * @see labelExpression
	 */
	public $label='Link';
	/**
	 * @var string a PHP expression that will be evaluated for every data cell and whose result will be rendered
	 * as the label of the hyperlink of the data cells. In this expression, the variable
	 * <code>$row</code> the row number (zero-based); <code>$data</code> the data model for the row;
	 * and <code>$this</code> the column object.
	 */
	public $labelExpression;
	/**
	 * @var string the URL to the image. If this is set, an image link will be rendered.
	 */
	public $imageUrl;
	/**
	 * @var string a PHP expression that will be evaluated for every data cell and whose result will be rendered
	 * as the URL to the image. In this expression, the variable
	 * <code>$row</code> the row number (zero-based); <code>$data</code> the data model for the row;
	 * and <code>$this</code> the column object.
	 */
	public $imageUrlExpression;
	/**
	 * @var string the URL of the hyperlinks in the data cells.
	 * This property is ignored if {@link urlExpression} is set.
	 * @see urlExpression
	 */
	public $url='javascript:void(0)';
	/**
	 * @var string a PHP expression that will be evaluated for every data cell and whose result will be rendered
	 * as the URL of the hyperlink of the data cells. In this expression, the variable
	 * <code>$row</code> the row number (zero-based); <code>$data</code> the data model for the row;
	 * and <code>$this</code> the column object.
	 */
	public $urlExpression;
	/**
	 * @var array the HTML options for the data cell tags.
	 */
	public $htmlOptions=array('class'=>'link-column');
	/**
	 * @var array the HTML options for the header cell tag.
	 */
	public $headerHtmlOptions=array('class'=>'link-column');
	/**
	 * @var array the HTML options for the footer cell tag.
	 */
	public $footerHtmlOptions=array('class'=>'link-column');
	/**
	 * @var array the HTML options for the hyperlinks
	 */
	public $linkHtmlOptions=array();
	
	/**
	 * @see CDataColumn::renderFilterCellContent
	 */
	protected function renderFilterCellContent()
	{
		if(is_string($this->filter))
			echo $this->filter;
		else if($this->filter!==false && $this->grid->filter!==null && $this->name!==null && strpos($this->name,'.')===false)
		{
			if( is_array($this->filter) )
			{
				if ( key_exists( 'prompt', $this->filter ) )
				{
					$prompt = $this->filter['prompt'];
					unset ( $this->filter['prompt'] );
				}
				else
					$prompt = '';
				echo CHtml::activeDropDownList( $this->grid->filter, $this->name, $this->filter, array( 'id' => false, 'prompt' => $prompt ) );
			}
			else if($this->filter===null)
				echo CHtml::activeTextField($this->grid->filter, $this->name, array('id'=>false));
		}
		else
			parent::renderFilterCellContent();
	}

	/**
	 * Renders the data cell content.
	 * This method renders a hyperlink in the data cell.
	 * @param integer $row the row number (zero-based)
	 * @param mixed $data the data associated with the row
	 */
	protected function renderDataCellContent($row,$data)
	{
		// Builds url for link
		if($this->urlExpression!==null)
			$url=$this->evaluateExpression($this->urlExpression,array('data'=>$data,'row'=>$row));
		else
			$url=$this->url;
		// Builds label for link
		if($this->labelExpression!==null)
			$label=$this->evaluateExpression($this->labelExpression,array('data'=>$data,'row'=>$row));
		else
			$label=$this->label;
		// Builds link for image
		if($this->imageUrlExpression!==null)
			$image=$this->evaluateExpression($this->imageUrlExpression,array('data'=>$data,'row'=>$row));
		else
			$image=$this->imageUrl;
		// Builds options of the link
		$options=$this->linkHtmlOptions;
		if ( key_exists( 'titleExpression', $options ) )
		{
			$options['title'] = $this->evaluateExpression( $options['titleExpression'], array( 'data' => $data, 'row' => $row ) );
			unset( $options['titleExpression'] );
		}
		if(is_string($image))
			echo CHtml::link(CHtml::image($image,$label),$url,$options);
		else
			echo CHtml::link($label,$url,$options);
	}
}
