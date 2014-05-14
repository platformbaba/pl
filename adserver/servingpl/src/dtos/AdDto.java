package dtos;

//if latlng!=null &&  obj.latlng!=null && conditiofailed continue;
			// if city!=null &&  obj.city!=null && conditiofailed continue;
			// if state!=null &&  obj.state!=null && conditiofailed continue;
			// if country!=null &&  obj.country!=null && conditiofailed continue;
				// all conidtions met here return obj;

public class AdDto {

	
	private boolean isFlash=false;
	private Double[] latlng;
	private String city;
	private String state;
	private String country;
	
	public boolean isFlash() {
		return isFlash;
	}
	public void setFlash(boolean isFlash) {
		this.isFlash = isFlash;
	}
	public Double[] getLatlng() {
		return latlng;
	}
	public void setLatlng(Double[] latlng) {
		this.latlng = latlng;
	}
	public String getCity() {
		return city;
	}
	public void setCity(String city) {
		this.city = city;
	}
	public String getState() {
		return state;
	}
	public void setState(String state) {
		this.state = state;
	}
	public String getCountry() {
		return country;
	}
	public void setCountry(String country) {
		this.country = country;
	}
	
	
}
