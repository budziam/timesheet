<?php
namespace App\Builders\Breadcrumb;

class BreadcrumbBuilder
{
    /**
     * List of breadcrumbs
     *
     * @var Breadcrumb[]
     */
    protected $breadcrumbs;

    public function __construct()
    {
        $this->breadcrumbs = [];
    }

    /**
     * @return static
     */
    public static function instance()
    {
        return app(static::class);
    }

    /**
     * Attaches new breadcrumb
     *
     * @param Breadcrumb $breadcrumb
     * @return $this
     */
    public function attachBreadcrumb(Breadcrumb $breadcrumb)
    {
        $this->breadcrumbs[] = $breadcrumb;

        return $this;
    }

    /**
     * Creates new breadcrumb and attaches it
     *
     * @param string $name
     * @param string $url
     * @return $this
     */
    public function attachNewBreadcrumb(string $name, string $url = null)
    {
        $this->attachBreadcrumb(new Breadcrumb(compact('name', 'url')));

        return $this;
    }

    /**
     * Returns collection of breadcrumbs
     *
     * @return \Illuminate\Support\Collection
     */
    public function getBreadcrumbs()
    {
        return collect($this->breadcrumbs);
    }

    /**
     * Returns a page title
     *
     * @return string
     */
    public function getPageTitle()
    {
        return collect($this->breadcrumbs)
            ->map(function (Breadcrumb $breadcrumb) {
                return $breadcrumb->getName();
            })
            ->reverse()
            ->push(config('app.name'))
            ->implode(' - ');
    }

    /**
     * Returns a short page title
     *
     * @return null|string
     */
    public function getShortPageTitle()
    {
        if (count($this->breadcrumbs) < 2) {
            return null;
        }

        return collect($this->breadcrumbs)
            ->slice(1, 1)
            ->first()
            ->getName();
    }
}