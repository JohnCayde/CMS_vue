<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateCmsPropTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_props', function (Blueprint $table) {
            $table->id();
            $table->integer('comp_id')->unsigned();
            $table->string('name', 100);
            $table->string('type', 100);
            $table->string('value', 100);
            $table->timestamps();
        });

        //Navbar
        $navbarId = DB::table('cms_comps')->insertGetId(
            array(
                'code' => Str::uuid(),
                'name' => "navbar"
            )
        );
        //Navbar props
        DB::table('cms_props')->insert(
            array(
                'comp_id' => $navbarId,
                'name' => "Hang",
                'type' => "Boolean",
                'value' => "false"
            )
        );
        DB::table('cms_props')->insert(
            array(
                'comp_id' => $navbarId,
                'name' => "Color",
                'type' => "Array",
                'value' => '["light red","light blue","light yellow"]'
            )
        );
        DB::table('cms_props')->insert(
            array(
                'comp_id' => $navbarId,
                'name' => "Logo",
                'type' => "Boolean",
                'value' => "false"
            )
        );
        DB::table('cms_props')->insert(
            array(
                'comp_id' => $navbarId,
                'name' => "Text Align",
                'type' => "Array",
                'value' => '["Left", "Center", "Right", "Seperate"]'
            )
        );
        DB::table('cms_props')->insert(
            array(
                'comp_id' => $navbarId,
                'name' => "Text Font",
                'type' => "Array",
                'value' => '["Normal", "Italic", "Bold"]'
            )
        );
        DB::table('cms_props')->insert(
            array(
                'comp_id' => $navbarId,
                'name' => "Hyperlink",
                'type' => "Array",
                'value' => "[]"
            )
        );

        //Card
        $cardId = DB::table('cms_comps')->insertGetId(
            array(
                'code' => Str::uuid(),
                'name' => "cards"
            )
        );
        //Card props
        DB::table('cms_props')->insert(
            array(
                'comp_id' => $cardId,
                'name' => "Count",
                'type' => "Array",
                'value' => "[1,2,3,4,5]"
            )
        );
        DB::table('cms_props')->insert(
            array(
                'comp_id' => $cardId,
                'name' => "Contain",
                'type' => "Boolean",
                'value' => "false"
            )
        );
        DB::table('cms_props')->insert(
            array(
                'comp_id' => $cardId,
                'name' => "Horizontal Align",
                'type' => "Array",
                'value' => '["Left", "Center", "Right"]'
            )
        );
        DB::table('cms_props')->insert(
            array(
                'comp_id' => $cardId,
                'name' => "Vertical Align",
                'type' => "Array",
                'value' => '["Top", "Center", "Bottom"]'
            )
        );
        DB::table('cms_props')->insert(
            array(
                'comp_id' => $cardId,
                'name' => "Content",
                'type' => "Array",
                'value' => "[]"
            )
        );

        //Carousel
        $CarouselId = DB::table('cms_comps')->insertGetId(
            array(
                'code' => Str::uuid(),
                'name' => "carousel"
            )
        );
        //Carousel props
        DB::table('cms_props')->insert(
            array(
                'comp_id' => $CarouselId,
                'name' => "Count",
                'type' => "Array",
                'value' => "[1,2,3,4,5]"
            )
        );
        DB::table('cms_props')->insert(
            array(
                'comp_id' => $CarouselId,
                'name' => "Horizontal Align",
                'type' => "Array",
                'value' => '["Left", "Center", "Right"]'
            )
        );
        DB::table('cms_props')->insert(
            array(
                'comp_id' => $CarouselId,
                'name' => "Vertical Align",
                'type' => "Array",
                'value' => '["Top", "Center", "Bottom"]'
            )
        );
        DB::table('cms_props')->insert(
            array(
                'comp_id' => $CarouselId,
                'name' => "Content",
                'type' => "Array",
                'value' => "[]"
            )
        );

        //Enquiry
        $EnquiryId = DB::table('cms_comps')->insertGetId(
            array(
                'code' => Str::uuid(),
                'name' => "enquiry"
            )
        );
        //Enquiry props
        DB::table('cms_props')->insert(
            array(
                'comp_id' => $EnquiryId,
                'name' => "Count",
                'type' => "Array",
                'value' => "[1,2,3,4,5]"
            )
        );
        DB::table('cms_props')->insert(
            array(
                'comp_id' => $EnquiryId,
                'name' => "Field",
                'type' => "Array",
                'value' => "[]"
            )
        );
        DB::table('cms_props')->insert(
            array(
                'comp_id' => $EnquiryId,
                'name' => "Button Align",
                'type' => "Array",
                'value' => '["Left", "Center", "Right"]'
            )
        );
        DB::table('cms_props')->insert(
            array(
                'comp_id' => $EnquiryId,
                'name' => "Button Colour",
                'type' => "Array",
                'value' => '["light red", "light blue", "light yellow"]'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_props');
    }
}
