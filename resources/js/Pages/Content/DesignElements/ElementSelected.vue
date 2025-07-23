<template>
    
    <Title v-if="props.elemType == 'title'" :on-done="props.onDone" :elem="props.elem"/>
    <TitleWithTypewriter v-if="props.elemType == 'title_typewrite'" :on-done="props.onDone" :elem="props.elem"/>
    <Html v-if="props.elemType == 'html'" :on-done="props.onDone" :elem="props.elem"/>
    <RichText v-if="props.elemType == 'richtext'" :on-done="props.onDone" :elem="props.elem"/>
    <Image v-if="props.elemType == 'image'" :on-done="props.onDone" :elem="props.elem"/>
    <Gallery v-if="props.elemType == 'gallery'" :on-done="props.onDone" :elem="props.elem"/>
    <ImageCard v-if="props.elemType == 'image_card'" :on-done="props.onDone" :elem="props.elem"/>
    <ImageCardGallery v-if="props.elemType == 'card_gallery'" :on-done="props.onDone" :elem="props.elem"/>
    <BladeTimelineSwiper v-if="props.elemType == 'timeline_swiper'" :on-done="props.onDone" :elem="props.elem"/>
    <Button v-if="props.elemType == 'button'" :on-done="props.onDone" :elem="props.elem"/>
    <Paragraph v-if="props.elemType == 'paragraph'" :on-done="props.onDone" :elem="props.elem"/>
    <Accordeon v-if="props.elemType == 'accordeon'" :on-done="props.onDone" :elem="props.elem"/>
    <Tab v-if="props.elemType == 'tab'" :on-done="props.onDone" :elem="props.elem"/>
    <IconCard v-if="props.elemType == 'iconcard'" :on-done="props.onDone" :elem="props.elem"/>
    <Blockquote v-if="props.elemType == 'blockquote'" :on-done="props.onDone" :elem="props.elem"/>
    <Video v-if="props.elemType == 'video'" :on-done="props.onDone" :elem="props.elem"/>
    <IconList v-if="props.elemType == 'icon_list'" :on-done="props.onDone" :elem="props.elem"/>
    <BladeModal v-if="props.elemType == 'modal_window'" :on-done="props.onDone" :elem="props.elem"/>
    <BladeOffCanvas v-if="props.elemType == 'offcanvas_window'" :on-done="props.onDone" :elem="props.elem"/>
    <Button v-if="props.elemType == 'modal_button'" :on-done="props.onDone" :elem="props.elem" :for-modal="true"/>
    <Button v-if="props.elemType == 'offcanvas_button'" :on-done="props.onDone" :elem="props.elem" :for-off-canvas="true"/>
    <BladeNestedColumns v-if="props.elemType == 'nested_columns'" :on-done="props.onDone" :elem="props.elem"/>

    <WidgetSlider v-if="props.elemType == 'slider'" :on-done="props.onDone" :elem="props.elem"/>
    <WidgetMenu v-if="props.elemType == 'menu'" :on-done="props.onDone" :elem="props.elem"/>
    <WidgetForm v-if="props.elemType == 'form'" :on-done="props.onDone" :elem="props.elem"/>
    <WidgetContents v-if="props.elemType == 'contents'" :on-done="props.onDone" :elem="props.elem"/>
    <WidgetContentCategories v-if="props.elemType == 'content_categories'" :on-done="props.onDone" :elem="props.elem"/>
    <WidgetDesignTemplate v-if="props.elemType == 'design_template'" :on-done="props.onDone" :elem="props.elem"/>
    <WidgetNewsletterForm v-if="props.elemType == 'newsletter_form'" :on-done="props.onDone" :elem="props.elem"/>
    <WidgetCommercialAds v-if="props.elemType == 'commercial_ads'" :on-done="props.onDone" :elem="props.elem"/>     
    <WidgetSocialAccounts v-if="props.elemType == 'social_accounts'" :on-done="props.onDone" :elem="props.elem"/>
    <WidgetSwiperNavigation v-if="props.elemType == 'swiper_navigation'" :on-done="props.onDone" :elem="props.elem"/>

    <LayoutTitle v-if="props.elemType == 'layout_title'" :on-done="props.onDone" :elem="props.elem"/>
    <LayoutSubTitle v-if="props.elemType == 'layout_subtitle'" :on-done="props.onDone" :elem="props.elem"/>
    <LayoutDependingTitle v-if="props.elemType == 'layout_depending_title'" :on-done="props.onDone" :elem="props.elem"/>
    <LayoutDependingContents v-if="props.elemType == 'layout_depending_contents'" :on-done="props.onDone" :elem="props.elem"/>
    <LayoutMainImage v-if="props.elemType == 'layout_mainimage'" :on-done="props.onDone" :elem="props.elem"/>
    <LayoutGalleryImages v-if="props.elemType == 'layout_gallery_images'" :on-done="props.onDone" :elem="props.elem"/>
    <LayoutSummary v-if="props.elemType == 'layout_summary'" :on-done="props.onDone" :elem="props.elem"/>
    <LayoutDescription v-if="props.elemType == 'layout_description'" :on-done="props.onDone" :elem="props.elem"/>
    <LayoutContentAttributes v-if="props.elemType == 'layout_content_attributes'" :on-done="props.onDone" :elem="props.elem"/>
    <LayoutContent v-if="props.elemType == 'layout_content'" :on-done="props.onDone" :elem="props.elem"/>
    <LayoutReadMoreButton v-if="props.elemType == 'layout_read_more_button'" :on-done="props.onDone" :elem="props.elem"/>
    <LayoutMeta v-if="props.elemType == 'layout_meta_data'" :on-done="props.onDone" :elem="props.elem"/>
    <LayoutIcon v-if="props.elemType == 'layout_icon'" :on-done="props.onDone" :elem="props.elem"/>

</template>

<script setup>

import Title from "./Title";
import TitleWithTypewriter from "./TitleWithTypewriter";
import Html from "./Html";
import RichText from "./RichText";
import Image from "./Image";
import Gallery from "./Gallery";
import ImageCard from "./ImageCard";
import ImageCardGallery from "./ImageCardGallery";
import BladeTimelineSwiper from "./BladeTimelineSwiper";
import Button from "./Button";
import Paragraph from "./Paragraph";
import Accordeon from "./Accordeon";
import Tab from "./Tab";
import IconCard from "./IconCard";
import Blockquote from "./Blockquote";
import Video from "./Video";
import IconList from "./IconList";
import BladeModal from './BladeModal';
import BladeOffCanvas from './BladeOffCanvas';
import BladeNestedColumns from './BladeNestedColumns';

import WidgetMenu from "./WidgetMenu";
import WidgetSlider from "./WidgetSlider";
import WidgetForm from "./WidgetForm";
import WidgetContents from "./WidgetContents";
import WidgetContentCategories from "./WidgetContentCategories";
import WidgetDesignTemplate from "./WidgetDesignTemplate";
import WidgetNewsletterForm from "./WidgetNewsletterForm";
import WidgetCommercialAds from "./WidgetCommercialAds";
import WidgetSocialAccounts from "./WidgetSocialAccounts";
import WidgetSwiperNavigation from "./WidgetSwiperNavigation";

import LayoutTitle from "./LayoutTitle";
import LayoutSubTitle from "./LayoutSubTitle";
import LayoutDependingTitle from "./LayoutDependingTitle";
import LayoutDependingContents from "./LayoutDependingContents";
import LayoutMainImage from "./LayoutMainImage";
import LayoutGalleryImages from "./LayoutGalleryImages";
import LayoutSummary from "./LayoutSummary";
import LayoutDescription from "./LayoutDescription";
import LayoutContentAttributes from "./LayoutContentAttributes";
import LayoutContent from "./LayoutContent";
import LayoutReadMoreButton from "./LayoutReadMoreButton";
import LayoutMeta from "./LayoutMeta";
import LayoutIcon from "./LayoutIcon";

const props = defineProps({
    elemType:String,
    elem:{
        type:Object,
        default:null
    },
    onDone:Function
});

</script>