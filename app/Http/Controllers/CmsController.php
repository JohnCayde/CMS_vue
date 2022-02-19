<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Page;
use App\Models\Comp;
use App\Models\Prop;
use App\Models\CompUser;
use App\Models\PropUser;

class CmsController extends Controller
{

    //
    public function cms()
    {
        if (Auth::check()) {
            return view("home");
        } else {
            return view('auth.login', ["from" => ""]);
        }
    }

    public function howTo()
    {
        return view("howto");
    }

    public function config()
    {
        return view("home");
    }

    public function preview($page = null)
    {
        $pages = $this->GetPage();
        if (count($pages) == 0) {
            return $pages;
            return view("preview", ["components" => []]);
        }
        $pageCodes = array_column($pages, "code");
        $pageIndex = $page ? array_search($page, $pageCodes) : 0;

        // dd($pages[$pageIndex]["components"]);
        $components = [];
        foreach ($pages[$pageIndex]["components"] as $i => $component) {
            switch ($component["name"]) {
                case 'navbar':
                    $comp = $this->navbarConverter($component);
                    array_push($components, $comp);
                    break;
                case 'cards':
                    $comp = $this->cardsConverter($component);
                    array_push($components, $comp);
                    break;
                case 'carousel':
                    $comp = $this->carouselConverter($component);
                    array_push($components, $comp);
                    break;
                case 'enquiry':
                    $comp = $this->enquiryConverter($component);
                    array_push($components, $comp);
                    break;
                default:
                    break;
            }
        }

        // dd($components);
        return view("preview", ["components" => $components]);
    }

    public function GetPage()
    {

        $userId = Auth::id();
        $rawPages = Page::select("name", "page_id")->where("user_id", $userId)->get();
        $pages = [];
        foreach ($rawPages as $i => $page) {
            $pg["page"] = $i + 1;
            $pg["name"] = $page->name;
            $pg["code"] = $page->page_id;


            $userComponents = CompUser::join("cms_comps", "cms_comp_users.comp_id", "=", "cms_comps.id")
                ->where("cms_comp_users.user_id", $userId)
                ->where("cms_comp_users.page_id", $page->page_id)
                ->select("cms_comps.name", "cms_comp_users.comp_code")
                ->get();

            $components = [];
            foreach ($userComponents as $j => $component) {

                $comp["name"] = $component->name;
                $comp["code"] = $component->comp_code;

                $userProps = PropUser::join("cms_props", "cms_prop_users.prop_id", "=", "cms_props.id")
                    ->where("cms_prop_users.comp_code", $component->comp_code)
                    ->select("cms_props.name", "cms_props.type", "cms_prop_users.value")
                    ->get();

                $props = [];
                foreach ($userProps as $k => $prop) {
                    if ($prop->name == "Hyperlink" || $prop->name == "Content" || $prop->name == "Field") {
                        $props[$prop->name] = json_decode($prop->value);
                    } else if ($prop->type == "Boolean") {
                        $props[$prop->name] = $prop->value === 'true' ? true : false;
                    } else {
                        $props[$prop->name] = $prop->value;
                    }
                }

                $comp["props"] = $props;

                array_push($components, $comp);
            }

            $pg["components"] = $components;
            array_push($pages, $pg);
        }

        return $pages;
    }

    public function AddPage(Request $req)
    {

        $newPage = new Page();
        $newPage->user_id = Auth::id();
        $newPage->page_id = md5($_SERVER['REQUEST_TIME']);
        $newPage->name = $req->name;
        $newPage->save();

        $pages = $this->GetPage();
        return $pages;
    }

    public function DelPage(Request $req)
    {

        $deletedPage = Page::where("user_id", Auth::id())
            ->where('page_id', $req->pageno)->delete();

        $pages = $this->GetPage();
        return $pages;
    }

    public function getComponent()
    {
        $rawComponents = Comp::select("id", "name")->get()->toArray();
        $componentIds = array_column($rawComponents, 'id');

        $rawProps = Prop::select("comp_id", "name", "type", "value")
            ->whereIn("comp_id", $componentIds)
            ->get();

        $components = [];
        foreach ($rawComponents as $i => $component) {
            $comp["name"] = $component["name"];
            $comp["code"] = md5($component["id"]);
            $comp["props"] = [];
            array_push($components, $comp);
        }

        foreach ($rawProps as $i => $prop) {
            $index =  array_search($prop->comp_id, $componentIds);
            if ($index === false) {
                continue;
            }

            $prp["name"] = $prop->name;
            $prp["type"] = $prop->type;
            $prp["value"] = json_decode($prop->value);

            array_push($components[$index]["props"], $prp);
        }

        return $components;
    }

    public function addComponent(Request $req)
    {

        //get comp id
        $component = Comp::select("id")
            ->where("code", $req->compCode)
            ->get();

        //get prop info
        $props = Prop::select("id", "name", "type")
            ->where("comp_id", $component[0]->id)
            ->get();

        //create uer comp
        $newComponent = new CompUser();
        $newComponent->user_id = Auth::id();
        $newComponent->page_id = $req->pageCode;
        $newComponent->comp_id = $component[0]->id;
        $newComponent->comp_code = md5($_SERVER['REQUEST_TIME']);
        $newComponent->save();

        //create user prop
        foreach ($props as $i => $prop) {
            $newProp = new PropUser();
            $newProp->comp_code = $newComponent->comp_code;
            $newProp->prop_id = $prop->id;

            switch ($prop->type) {
                case 'Boolean':
                    $newProp->value =  "false";
                    break;
                default:
                    if ($prop->name == "Hyperlink" || $prop->name == "Content" || $prop->name == "Field") {
                        $newProp->value =  "[]";
                    } else {
                        $newProp->value = "";
                    }
                    break;
            }
            $newProp->save();
        }

        $pages = $this->GetPage();
        return $pages;
    }

    public function delComponent(Request $req)
    {

        //delete comp and props
        $deletedProps = PropUser::where('comp_code', $req->compCode)->delete();
        $deletedComponents = CompUser::where("user_id", Auth::id())
            ->where('page_id', $req->pageCode)
            ->where('comp_code', $req->compCode)->delete();

        $pages = $this->GetPage();
        return $pages;
    }

    public function upComponent(Request $req)
    {

        $props = CompUser::join("cms_props", "cms_comp_users.comp_id", "=", "cms_props.comp_id")
            ->where("cms_comp_users.user_id", Auth::id())
            ->where('cms_comp_users.page_id', $req->pageCode)
            ->where('cms_comp_users.comp_code', $req->compCode)
            ->select("cms_props.id", "cms_props.name", "cms_props.type")
            ->get()->toArray();

        // return $props;
        $deletedProps = PropUser::where('comp_code', $req->compCode)->delete();

        $propNames = array_column($props, "name");
        foreach ($req->props as $i => $prp) {
            $index =  array_search($prp["name"], $propNames);
            if ($index === false) {
                continue;
            }

            $newProp = new PropUser();
            $newProp->comp_code = $req->compCode;
            $newProp->prop_id = $props[$index]["id"];

            switch ($props[$index]["type"]) {
                case 'Boolean':
                    $newProp->value =  $prp["value"] ? 'true' : 'false';
                    break;
                default:
                    if ($props[$index]["name"] == "Hyperlink" || $props[$index]["name"] == "Content" || $props[$index]["name"] == "Field") {
                        $newProp->value =  json_encode($prp["value"]);
                    } else {
                        $newProp->value = $prp["value"];
                    }
                    break;
            }
            $newProp->save();
        }

        $pages = $this->GetPage();
        return $pages;
    }

    public function sendMessage(Request $req)
    {
        // $msg = [];
        // foreach ($req->request as $key => $value) {
        //     $msg[$key]=$value;
        // }
        // unset($msg["_token"]);

        // $email = Auth::user()->email;
        // Mail::to($email)->send(new CmsMessage($msg));
        return redirect()->back();
    }

    private function navbarConverter($component)
    {
        $primaryClass = "w-100 d-flex align-items-center py-2";

        if ($component["props"]["Hang"]) {
            $primaryClass .= " container-fluid position-absolute";
        } else {
            $primaryClass .= " container";
        }


        switch ($component["props"]["Color"]) {
            case "light red":
                $primaryClass .= " bg-danger";
                break;
            case "light blue":
                $primaryClass .= " bg-primary";
                break;
            case "light yellow":
                $primaryClass .= " bg-warning";
                break;
            default:
                break;
        }

        switch ($component["props"]["Text Align"]) {
            case "Left":
                $primaryClass .= " justify-content-start";
                break;
            case "Center":
                $primaryClass .= " justify-content-center";
                break;
            case "Right":
                $primaryClass .= " justify-content-end";
                break;
            case "Seperate":
                $primaryClass .= " justify-content-between";
                break;
            default:
                break;
        }

        $secondaryClass = "mx-2 text-white text-decoration-none fs-4 mx-3";
        switch ($component["props"]["Text Font"]) {
            case "Italic":
                $secondaryClass .= " fst-italic";
                break;
            case "Bold":
                $secondaryClass .= " fw-bold";
                break;
            default:
                $secondaryClass .= " fw-normal";
                break;
        }

        unset($component["props"]["Color"]);
        unset($component["props"]["Text Align"]);
        unset($component["props"]["Text Font"]);

        $component["primaryClass"] = $primaryClass;
        $component["secondaryClass"] = $secondaryClass;

        return $component;
    }

    private function cardsConverter($component)
    {
        $primaryClass = "bg-secondary mb-4 w-100 preview position-relative d-flex align-items-center";

        if ($component["props"]["Contain"]) {
            $primaryClass .= " container justify-content-center";
        } else {
            $primaryClass .= " justify-content-around";
        }

        $secondaryClass = "preview-card m-3 d-flex";
        switch ($component["props"]["Horizontal Align"]) {
            case "Left":
                $secondaryClass .= " justify-content-start";
                break;
            case "Center":
                $secondaryClass .= " justify-content-center";
                break;
            case "Right":
                $secondaryClass .= " justify-content-end";
                break;
            default:
                break;
        }

        switch ($component["props"]["Vertical Align"]) {
            case "Top":
                $secondaryClass .= " align-items-start";
                break;
            case "Center":
                $secondaryClass .= " align-items-center";
                break;
            case "Bottom":
                $secondaryClass .= " align-items-end";
                break;
            default:
                break;
        }

        unset($component["props"]["Count"]);
        unset($component["props"]["Contain"]);
        unset($component["props"]["Horizontal Align"]);
        unset($component["props"]["Vertical Align"]);

        $component["primaryClass"] = $primaryClass;
        $component["secondaryClass"] = $secondaryClass;

        return $component;
    }

    private function carouselConverter($component)
    {
        $primaryClass = "preview-container h-100 mx-5 d-flex";
        switch ($component["props"]["Horizontal Align"]) {
            case "Left":
                $primaryClass .= " justify-content-start";
                break;
            case "Center":
                $primaryClass .= " justify-content-center";
                break;
            case "Right":
                $primaryClass .= " justify-content-end";
                break;
            default:
                break;
        }

        switch ($component["props"]["Vertical Align"]) {
            case "Top":
                $primaryClass .= " align-items-start";
                break;
            case "Center":
                $primaryClass .= " align-items-center";
                break;
            case "Bottom":
                $primaryClass .= " align-items-end";
                break;
            default:
                break;
        }

        unset($component["props"]["Horizontal Align"]);
        unset($component["props"]["Vertical Align"]);
        unset($component["props"]["Count"]);

        $component["primaryClass"] = $primaryClass;
        return $component;
    }

    private function enquiryConverter($component)
    {
        $primaryClass = "d-flex mt-3";
        switch ($component["props"]["Button Align"]) {
            case "Left":
                $primaryClass .= " justify-content-start";
                break;
            case "Center":
                $primaryClass .= " justify-content-center";
                break;
            case "Right":
                $primaryClass .= " justify-content-end";
                break;
            default:
                break;
        }

        $secondaryClass = "m-3 d-flex btn";
        switch ($component["props"]["Button Colour"]) {
            case "light red":
                $secondaryClass .= " btn-danger";
                break;
            case "light blue":
                $secondaryClass .= " btn-primary";
                break;
            case "light yellow":
                $secondaryClass .= " btn-warning";
                break;
            default:
                break;
        }

        unset($component["props"]["Count"]);
        unset($component["props"]["Button Align"]);
        unset($component["props"]["Button Colour"]);

        $component["primaryClass"] = $primaryClass;
        $component["secondaryClass"] = $secondaryClass;
        return $component;
    }
}
