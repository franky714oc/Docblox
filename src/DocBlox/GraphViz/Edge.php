<?php
/**
 * Class representing an edge (arrow, line).
 *
 * @category  DocBlox
 * @package   GraphViz
 * @author    Mike van Riel <mike.vanriel@naenius.com>
 * @copyright Copyright (c) 2011-201 Mike van Riel / Naenius (http://www.naenius.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
class DocBlox_GraphViz_Edge {

  /** @var DocBlox_GraphViz_Node Node from where to link */
  protected $from = null;

  /** @var DocBlox_GraphViz_Node Node where to to link */
  protected $to   = null;

  /** @var DocBlox_GraphViz_Attribute List of attributes for this edge */
  protected $attributes = array();

  /**
   * Creates a new Edge / Link between the given nodes.
   *
   * @param DocBlox_GraphViz_Node $from
   * @param DocBlox_GraphViz_Node $to
   */
  function __construct(DocBlox_GraphViz_Node $from, DocBlox_GraphViz_Node $to)
  {
    $this->from = $from;
    $this->to   = $to;
  }

  /**
   * Factory method used to assist with fluent interface handling.
   *
   * See the examples for more details.
   *
   * @param DocBlox_GraphViz_Node $from
   * @param DocBlox_GraphViz_Node $to
   *
   * @return DocBlox_GraphViz_Edge
   */
  public static function create(DocBlox_GraphViz_Node $from, DocBlox_GraphViz_Node $to)
  {
    return new self($from, $to);
  }

  /**
   * Returns the source Node for this Edge.
   *
   * @return DocBlox_GraphViz_Node
   */
  public function getFrom()
  {
    return $this->from;
  }

  /**
   * Returns the destination Node for this Edge.
   *
   * @return DocBlox_GraphViz_Node
   */
  public function getTo()
  {
    return $this->to;
  }

  /**
   * Magic method to provide a getter/setter to add attributes on the edge.
   *
   * Using this method we make sure that we support any attribute without too much hassle.
   * If the name for this method does not start with get or set we return null.
   *
   * Set methods return this graph (fluent interface) whilst get methods return the attribute value.
   *
   * @param string  $name
   * @param mixed[] $arguments
   *
   * @return DocBlox_GraphViz_Attribute[]|DocBlox_GraphViz_Edge|null
   */
  function __call($name, $arguments)
  {
    $key = strtolower(substr($name, 3));
    if (strtolower(substr($name, 0, 3)) == 'set')
    {
      $this->attributes[$key] = new DocBlox_GraphViz_Attribute($key, $arguments[0]);
      return $this;
    }
    if (strtolower(substr($name, 0, 3)) == 'get')
    {
      return $this->attributes[$key];
    }

    return null;
  }

  /**
   * Returns the edge definition as is requested by GraphViz.
   *
   * @return string
   */
  public function __toString()
  {
    $attributes = array();
    foreach ($this->attributes as $value)
    {
      $attributes[] = (string)$value;
    }
    $attributes = implode("\n", $attributes);

    return <<<DOT
{$this->getFrom()->getName()} -> {$this->getTo()->getName()} [
$attributes
]
DOT;
  }
}
